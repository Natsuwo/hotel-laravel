<?php

namespace App\Http\Controllers;

use App\Models\Housekeeping;
use App\Models\Rooms;
use App\Models\RoomTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HousekeepingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->query('perpage', 10);
        $search = request()->query('search', '');

        $sortField = request()->query('sort_field', '');
        $sortOrder = request()->query('sort_order', 'asc');
        $roomTypesFilter = (array) request()->query('room_type', []);
        $houseKeepingStatusFilter = (array) request()->query('status', []);
        $priorityFilter = (array) request()->query('priority', []);

        $records = Rooms::leftJoin('housekeeping', 'rooms.id', '=', 'housekeeping.room_id')
            ->leftJoin('reservations', 'rooms.id', '=', 'reservations.room_id')
            ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
            ->select(
                'rooms.*',
                'room_types.title as room_type',
                'floors.floor_number as floor',
                'housekeeping.status as housekeeping_status',
                'housekeeping.priority as housekeeping_priority',
                'housekeeping.notes as notes',
                'reservations.status as reservation_status',
                'reservations.id as booking_id'
            )
            ->when($search, function ($query, $search) {
                return $query->where('rooms.room_number', 'like', "%{$search}%")
                    ->orWhere('room_types.title', 'like', "%{$search}%");
            })
            ->when($sortField, function ($query, $sortField) use ($sortOrder) {
                $validSortFields = [
                    'room_number' => 'rooms.room_number',
                    'room_type' => 'room_types.title',
                    'housekeeping_status' => 'housekeeping.status',
                    'priority' => 'housekeeping.priority',
                    'floor' => 'floors.floor_number',
                    'reservation_status' => 'reservations.status',
                ];

                if (array_key_exists($sortField, $validSortFields)) {
                    if ($sortField === 'room_number') {
                        return $query->orderBy(DB::raw('CAST(rooms.room_number AS UNSIGNED)'), $sortOrder);
                    }
                    return $query->orderBy($validSortFields[$sortField], $sortOrder);
                }
            })
            ->when($roomTypesFilter, function ($query, $roomTypesFilter) {
                return $query->whereIn('room_types.title', $roomTypesFilter);
            })
            ->when($houseKeepingStatusFilter, function ($query, $houseKeepingStatusFilter) {
                return $query->whereIn('housekeeping.status', $houseKeepingStatusFilter);
            })
            ->when($priorityFilter, function ($query, $priorityFilter) {
                return $query->whereIn('housekeeping.priority', $priorityFilter);
            })
            ->paginate($perPage);

        $roomTypeNames = RoomTypes::pluck('title');
        return view('admin.pages.housekeeping.index', compact('records', 'roomTypeNames'));
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateField(Request $request)
    {
        $field = $request->input('field');
        $room_id = $request->input('room_id');
        $booking_id = $request->input('booking_id') ?? null;
        $value = $request->input('value');
        $fields = ['status', 'priority', 'notes'];
        if (in_array($field, $fields)) {
            $updateData = ['booking_id' => $booking_id, $field => $value];
            $result = Housekeeping::updateOrCreate(['room_id' => $room_id], $updateData);
            return redirect()->back()->with(
                $result ? 'success' : 'error',
                $result ? ucfirst($field) . ' updated successfully' : 'Failed to update ' . $field
            );
        }
    }
}
