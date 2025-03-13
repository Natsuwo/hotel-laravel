<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'transaction_id' => 'required|string',
            'payment_method' => 'required|in:cash,card,paypal,momo,bank_transfer,vnpay', // 'cash','card','paypal','momo','bank_transfer','vnpay'
            'paid_at' => 'nullable|date',
        ]);

        $payment = Payment::create([
            'invoice_id' => $validated['invoice_id'],
            'transaction_id' => $validated['transaction_id'],
            'status' => $request->status ? $request->status : 'unpaid',
            'payment_method' => $validated['payment_method'],
            'paid_at' => $validated['paid_at'] ?? null,
        ]);

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Payment created successfully',
                'data' => $payment
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $payment = Payment::where('id', $id)
            ->orWhere('transaction_id', $id)
            ->with(
                'invoice',
                'invoice.reservation',
                'invoice.room',
                'invoice.room.roomType',
                'invoice.room.roomType.galleries.gallery'
            )
            ->first();

        if ($payment) {
            $gallery = $payment->invoice?->room?->roomType?->galleries?->first()?->gallery;
            if (!$gallery) return null;
            $disk = Storage::disk('r2'); // Assuming you are using S3
            $payment->thumbnail = $disk->temporaryUrl($gallery->path, now()->addMinutes(5));
            return response()->json([
                'success' => true,
                'data' => $payment
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::where('id', $id)
            ->orWhere('transaction_id', $id);

        if ($payment) {
            $validated = $request->validate([
                'status' => 'required|in:paid,unpaid,failed,cancelled,refunded'
            ]);

            $payment->update([
                'status' => $validated['status'],
                'paid_at' => Carbon::now()
            ]);

            if ($validated['status'] == 'paid') {
                $invoice = $payment->first()->invoice;
                if ($invoice->status == 'paid') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invoice already paid'
                    ]);
                }

                $invoice->update([
                    'status' => 'paid'
                ]);

                $reservation = $invoice->reservation;
                $reservation->update([
                    'status' => 1
                ]);

                $paymentInstance = $payment->first();
                $paymentInstance->plusPoint($invoice->amount);

                Transaction::create([
                    'transaction_date' => Carbon::now(),
                    'amount' => $invoice->amount,
                    'type' => 'income',
                    'category' => 'Booking',
                    'description' => 'Income from bookingID: ' . $reservation->booking_id,
                ]);
            }

            if ($request->is('api/*')) {
                $payment = $payment->get();
                return response()->json([
                    'success' => true,
                    'message' => 'Payment updated successfully',
                    'data' => $payment
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
