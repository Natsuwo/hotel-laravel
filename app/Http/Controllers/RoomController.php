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

        return redirect()->route('admin.room_types.index')
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Create room successfully' : 'Create room failed'
            );
    }
}
