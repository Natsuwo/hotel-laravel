<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Http\Requests\Reservation\StoreRequest as ReservationStoreRequest;
use App\Http\Requests\Reservation\UpdateRequest as ReservationUpdateRequest;
use App\Models\Guests;
use App\Models\Invoices;
use App\Models\Payment;
use App\Models\Rooms;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = request()->query('perpage', 10);
        $reservations = Reservations::with(['room', 'guest'])
            ->paginate($perpage);
        return view('admin.pages.reservation.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.reservation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationStoreRequest $request)
    {

        $bookingId = Reservations::generateBookingId();
        $reservation = Reservations::create([
            'room_id' => $request->room_id,
            'booking_id' => $bookingId,
            'guest_id' => $request->guest_id,
            'check_in' => Carbon::parse($request->check_in)->format('Y-m-d\TH:i'),
            'check_out' => Carbon::parse($request->check_out)->format('Y-m-d\TH:i'),
            'duration' => $request->duration,
            'adults' => $request->adults,
            'children' => $request->child,
            'notes' => $request->notes,
            'status' => $request->status ? $request->status : 0, // 0: pending, 1: confirm, 2: rejected, 3: cancelled
        ]);

        if ($reservation->id) {
            $vat = $request->vat_price ? $request->vat_price : 0; // 10%
            $tax = $request->tax_price ? $request->tax_price : 0; // 5%
            $extras = 0;
            $total = $request->total_price ? $request->total_price : $request->price * $request->duration;
            $invoice =  Invoices::createInvoice([
                'guest_id' => $request->guest_id,
                'room_id' => $request->room_id,
                'booking_id' => $reservation->id,
                'coupon_id' => null,
                'price_per_night' => $request->price,
                'extras' => $extras,
                'vat' => $vat,
                'tax' => $tax,
                'amount' => $total,
                'status' => 'unpaid',
            ]);

            $reservation->invoice_id = $invoice->id;

            // create payment

            if ($request->session_id && $request->payment_method == 'card') {
                $payment = Payment::create([
                    'invoice_id' => $invoice->id,
                    'transaction_id' => $request->session_id,
                    'status' => 'unpaid',
                    'payment_method' => $request->payment_method,
                    'paid_at' => null,
                ]);

                $reservation->payment_id = $payment->id;
            }
        }



        // if ($request->status == 1 || $request->status == 0) {
        //     Rooms::updateStatus($request->room_id, 'occupied');
        // }

        if (request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Reservation created successfully',
                'data' => $reservation,
            ]);
        }

        return redirect()->route('admin.reservation.index')
            ->with(
                $reservation ? 'success' : 'error',
                $reservation ? 'Reservation created successfully' : 'Failed to create reservation'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $limit = $request->query('limit', 10);
        $page = $request->query('page', 1);
        $room_ids = Rooms::where('room_type_id', $id)->pluck('id');
        $month = $request->query('month', null);
        $year = $request->query('year', null);
        $check_in = $request->query('check_in', Carbon::now());
        $check_out = $request->query('check_out', Carbon::now());

        if ($month && $year) {
            $check_in = Carbon::create($year, $month, 1, 0, 0, 0, 'Asia/Bangkok')->startOfMonth();
            $check_out = $check_in->copy()->addMonth()->endOfMonth();
        }

        $reservations = Reservations::whereIn('room_id', $room_ids)
            ->where('status', 1)
            ->where(function ($query) use ($check_in, $check_out) {
                $query->where('check_in', '<=', $check_out)
                    ->where('check_out', '>=', $check_in);
            })
            ->orderBy('check_out', 'desc')
            ->get()
            ->unique('room_id');


        $totalRooms = Rooms::whereIn('id', $room_ids)->where('status', 'available')->count();
        $roomAvailble = Rooms::whereIn('id', $room_ids)
            ->where('status', 'available')
            ->whereNotIn('id', $reservations->pluck('room_id'))
            ->get();
        $occupiedRooms = $reservations->count();
        $roomsLeft = $totalRooms - $occupiedRooms;
        return response()->json([
            'success' => true,
            'data' => $reservations,
            'rooms' => $roomAvailble,
            'rooms_left' => $roomsLeft,
        ]);
    }

    public function getByRoomNumber(Request $request, string $id)
    {
        $room_number =  $id;
        $room = Rooms::where('room_number', $room_number)->first();

        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $check_in = Carbon::create($year, $month, 1, 0, 0, 0, 'Asia/Bangkok')->startOfMonth();
        $check_out = $check_in->copy()->addMonth()->endOfMonth();

        $reservations = Reservations::where('room_id', $room->id)
            ->where(function ($query) use ($check_in, $check_out) {
                $query->where(function ($query) use ($check_in, $check_out) {
                    $query->where('check_in', '<=', $check_out)
                        ->where('check_out', '>=', $check_in);
                });
            })->get();

        return response()->json([
            'success' => true,
            'data' => $reservations,
        ]);
    }

    public function getById(string $id)
    {
        $reservation = Reservations::with([
            'room',
            'guest',
            'invoice',
            'room.roomType',
            'room.roomType.galleries.gallery',
        ])->findOrFail($id);

        $reservation->thumbnail = $reservation?->room?->roomType?->galleries?->first()?->gallery?->thumbUrl();
        return response()->json([
            'success' => true,
            'data' => $reservation,
        ]);
    }

    public function getByGuestId(string $id)
    {
        $reservation = Reservations::with([
            'room',
            'invoice',
            'invoice.payment',
            'room.roomType.galleries.gallery',
        ])->where('guest_id', $id)
            ->get();

        $reservation = $reservation->map(function ($item) {
            $item->thumbnail = $item?->room?->roomType?->galleries?->first()?->gallery?->thumbUrl();
            return $item;
        });
        return response()->json([
            'success' => true,
            'data' => $reservation,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Reservations::findOrFail($id);
        return view('admin.pages.reservation.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationUpdateRequest $request, string $id)
    {
        $reservation = Reservations::findOrFail($id);
        $check_in = $request->check_in;
        $check_out = $request->check_out;
        $duration = $request->duration ? $request->duration : abs(Carbon::parse($check_out)->diffInDays(Carbon::parse($check_in)));

        $reservation->update(array_filter([
            'room_id' => $request->room_id,
            'guest_id' => $request->guest_id,
            'check_in' => $request->check_in ? Carbon::parse($request->check_in)->format('Y-m-d\TH:i') : null,
            'check_out' => $request->check_out ? Carbon::parse($request->check_out)->format('Y-m-d\TH:i') : null,
            'duration' => $duration,
            'adults' => $request->adults,
            'children' => $request->child,
            'notes' => $request->notes,
            'status' => $request->status,
        ], function ($value) {
            return !is_null($value);
        }));



        $settings = Settings::whereIn('name', ['vat', 'tax'])->get();
        $invoices = Invoices::where('booking_id', $reservation->id);
        $total_price = $request->total_price ?
            $request->total_price :
            $reservation->room->roomType->price_per_night * $duration;
        $tax_price = $request->tax_price ? $request->tax_price : $total_price * $settings->where('name', 'tax')->first()->value / 100;
        $vat_price = $request->vat_price ? $request->vat_price : $total_price * $settings->where('name', 'vat')->first()->value / 100;


        if (!$request->total_price) {
            $total_price = $total_price + $vat_price + $tax_price;
        }


        $paid_invoices = $invoices->where('status', 'paid')->get();
        $total_paid = $paid_invoices->sum('amount');
        $new_price_must_pay = $total_price - $total_paid;
        $new_tax_price = $tax_price - $paid_invoices->sum('tax');
        $new_vat_price = $vat_price - $paid_invoices->sum('vat');


        if ($new_price_must_pay > 0) {
            $invoice =  Invoices::create([
                'guest_id' => $reservation->guest_id,
                'room_id' => $reservation->room_id,
                'booking_id' => $reservation->id,
                'coupon_id' => null,
                'price_per_night' => $reservation->room->roomType->price_per_night,
                'extras' => 0,
                'vat' => $new_vat_price,
                'tax' => $new_tax_price,
                'amount' => $new_price_must_pay,
                'status' => 'unpaid',
            ]);

            $invoice->reservation =  $reservation;
            $reservation->status = 0;
            $reservation->save();
        }

        if (request()->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $invoice ?? null,
                'message' => 'Reservation updated successfully',
            ]);
        }


        return redirect()->route('admin.reservation.index')
            ->with(
                $reservation ? 'success' : 'error',
                $reservation ? 'Reservation updated successfully' : 'Failed to update reservation'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $reservation = Reservations::findOrFail($id);
        $reservation->delete();

        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Reservation deleted successfully',
            ]);
        }

        return redirect()->route('admin.reservation.index')
            ->with(
                $reservation ? 'success' : 'error',
                $reservation ? 'Reservation deleted successfully' : 'Failed to delete reservation'
            );
    }

    /**
     * Update the status of the reservation.
     */

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:reservations,id',
            'status' => 'required|in:0,1,2,3', // 0: pending, 1: confirm, 2: rejected, 3: cancelled
        ]);

        $reservation = Reservations::findOrFail($request->id);

        // $roomId = $reservation->room_id;

        // if ($request->status == 1 || $request->status == 0) {
        //     Rooms::updateStatus($roomId, 'occupied');
        // } else {
        //     Rooms::updateStatus($roomId, 'available');
        // }

        $reservation->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Reservation status updated successfully',
        ]);
    }

    /**
     * Display the guest profile.
     */

    public function guestProfile(Request $request, string $guest_id)
    {
        $search = $request->query('search');
        $date = $request->query('date');

        $latestReservation = Reservations::where('guest_id', $guest_id)
            ->with([
                'room',
                'guest',
                'invoice',
                'room.roomType',
                'room.roomType.galleries.gallery',
                'room.roomType.amenities.feature',
                'room.roomType.facilities.feature',
                'room.roomType.features.feature',
            ])
            ->orderBy('updated_at', 'desc')
            ->first();

        $reservations = Reservations::with([
            'room',
            'room.roomType',
            'room.roomType.galleries.gallery',
        ])
            ->where('guest_id', $guest_id)
            ->when($search, function ($query, $search) {
                return $query->where('booking_id', 'like', "%{$search}%");
            })
            ->when($date, function ($query, $date) {
                $dates = explode(' - ', $date);
                $from = Carbon::parse($dates[0])->startOfDay();
                $to = Carbon::parse($dates[1])->endOfDay();
                return $query->whereBetween('check_in', [$from, $to]);
            })
            ->get();
        $membership = Guests::find($guest_id)->guestMembership();
        return view('admin.pages.reservation.profile', compact('reservations', 'membership', 'latestReservation'));
    }
}
