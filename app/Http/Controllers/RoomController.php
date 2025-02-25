<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function create()
    {
        $floors = DB::table('floors')->get();
        $roomTypes = DB::table('room_types')->get();
        return view('admin.pages.room.create', [
            'floors' => $floors,
            'roomTypes' => $roomTypes
        ]);
    }

    public function store(StoreRequest $request)
    {
        $check = DB::table('rooms')->insert([
            'room_number' => $request->room_number,
            'floor_id' => $request->floor_id,
            'room_type_id' => $request->room_type_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.room.create')
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Create room successfully' : 'Create room failed'
            );
    }

    public function edit($id)
    {
        $room = DB::table('rooms')->find($id);
        $floors = DB::table('floors')->get();
        $roomTypes = DB::table('room_types')->get();
        return view('admin.pages.room.edit', [
            'room' => $room,
            'floors' => $floors,
            'roomTypes' => $roomTypes
        ]);
    }

    public function update(StoreRequest $request, $id)
    {
        $check = DB::table('rooms')->where('id', $id)->update([
            'room_number' => $request->room_number,
            'floor_id' => $request->floor_id,
            'room_type_id' => $request->room_type_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.room.edit', ['id' => $id])
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Update room successfully' : 'Update room failed'
            );
    }

    public function destroy($id)
    {
        $check = DB::table('rooms')->where('id', $id)->delete();
        return redirect()->route('admin.room_types.index', ['filter' => 'room_id'])
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Delete room successfully' : 'Delete room failed'
            );
    }

    public function getRooms(Request $request)
    {
        $search = $request->query('name');
        $rooms = DB::table('rooms')
            ->where('status', 'available')
            ->where('room_number', 'like', "%$search%")
            ->leftJoin('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select('rooms.*', 'room_types.price_per_night as price')
            ->limit(10)
            ->get();
        return response()->json($rooms);
    }
}
