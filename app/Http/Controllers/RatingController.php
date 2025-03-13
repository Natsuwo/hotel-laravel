<?php

namespace App\Http\Controllers;

use App\Models\Ratings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RatingController extends Controller
{
    public function index()
    {
        $limit = 10;
        $ratings = Ratings::with('user', 'roomType', 'room', 'booking')->paginate($limit);
        return view('admin.pages.rating.index', compact('ratings'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->validate([
                'guest_id' => 'required|exists:guests,id',
                'room_type_id' => 'required|exists:room_types,id',
                'room_id' => 'required|exists:rooms,id',
                'booking_id' => 'required|exists:reservations,id',
                'rating' => 'required|numeric|min:1|max:5',
                'comment' => 'nullable|string',
            ]);
            $rating =   Ratings::updateOrCreate([
                'guest_id' => $data['guest_id'],
                'room_type_id' => $data['room_type_id'],
                'room_id' => $data['room_id'],
                'booking_id' => $data['booking_id'],
            ], $data);

            DB::commit();

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $rating,
                    'message' => 'Rating created successfully'
                ]);
            }

            return redirect()->route('admin.rating.index')
                ->with('success', 'Rating created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            return redirect()->route('admin.rating.index')
                ->with('error', $e->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            $guest_id = $request->get('guest_id');
            $room_type_id = $request->get('room_type_id');
            $room_id = $request->get('room_id');
            $booking_id = $request->get('booking_id');
            if (!$guest_id || !$room_type_id || !$room_id || !$booking_id) {
                throw new \Exception('Invalid request');
            }
            $rating = Ratings::where('guest_id', $guest_id)
                ->where('room_type_id', $room_type_id)
                ->where('room_id', $room_id)
                ->where('booking_id', $booking_id)
                ->first();
            if (!$rating) {
                throw new \Exception('Rating not found');
            }

            if ($request->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'data' => $rating
                ]);
            }

            return view('admin.pages.rating.show', compact('rating'));
        } catch (\Exception $e) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            return redirect()->route('admin.rating.index')
                ->with('error', $e->getMessage());
        }
    }
}
