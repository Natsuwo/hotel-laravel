<?php

namespace App\Http\Controllers;

use App\Models\Reservations;
use App\Http\Requests\Reservation\StoreRequest as ReservationStoreRequest;
use App\Http\Requests\Reservation\UpdateRequest as ReservationUpdateRequest;
use App\Models\Guests;
use App\Models\Invoices;
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
            'status' => $request->status,
        ]);

        if ($reservation->id) {
            $vat = 10; // 10%
            $tax = 1; // 1%
            $extras = 0;
            $amount = $request->price_per_night * $request->duration;
            $total = $amount + $extras + ($amount * $vat / 100) + ($amount * $tax / 100);
            Invoices::createInvoice([
                'guest_id' => $request->guest_id,
                'room_id' => $request->room_id,
                'booking_id' => $reservation->id,
                'coupon_id' => null,
                'price_per_night' => $request->price_per_night,
                'extras' => $extras,
                'vat' => $vat,
                'tax' => $tax,
                'amount' => $total,
                'status' => 'unpaid',
            ]);
        }

        // if ($request->status == 1 || $request->status == 0) {
        //     Rooms::updateStatus($request->room_id, 'occupied');
        // }

        return redirect()->route('admin.reservation.index')
            ->with(
                $reservation ? 'success' : 'error',
                $reservation ? 'Reservation created successfully' : 'Failed to create reservation'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $reservation->update([
            'room_id' => $request->room_id,
            'guest_id' => $request->guest_id,
            'check_in' => Carbon::parse($request->check_in)->format('Y-m-d\TH:i'),
            'check_out' => Carbon::parse($request->check_out)->format('Y-m-d\TH:i'),
            'duration' => $request->duration,
            'adults' => $request->adults,
            'children' => $request->child,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.reservation.index')
            ->with(
                $reservation ? 'success' : 'error',
                $reservation ? 'Reservation updated successfully' : 'Failed to update reservation'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservations::findOrFail($id);
        $reservation->delete();
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
