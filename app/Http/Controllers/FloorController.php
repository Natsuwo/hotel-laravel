<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FloorController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $records = DB::table('floors')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
        return view('admin.pages.floor.index', [
            'records' => $records,
        ]);
    }

    public function create()
    {
        return view('admin.pages.floor.create');
    }

    public function store(Request $request)
    {
        // validate
        $request->validate([
            'floor_number' => 'required|string|max:255',
        ]);

        // Check for duplicate floor number
        $duplicate = DB::table('floors')->where('floor_number', $request->floor_number)->exists();

        if ($duplicate) {
            return redirect()->back()->with('error', 'Floor number already exists.');
        }

        $check = DB::table('floors')->insert([
            'floor_number' => $request->floor_number,
        ]);

        return redirect()->route('admin.floor.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data updated successfully' : 'Failed to update data'
            );
    }

    public function detail($id)
    {
        $record = DB::table('floors')->where('id', $id)->first();
        return view('admin.pages.floor.detail', [
            'record' => $record,
        ]);
    }

    public function update(Request $request, $id)
    {
        // validate
        $request->validate([
            'floor_number' => 'required|string|max:255',
        ]);

        $check =  DB::table('floors')->where('id', $id)->update([
            'floor_number' => $request->floor_number,
        ]);


        return redirect()->route('admin.floor.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data updated successfully' : 'Failed to update data'
            );
    }

    public function delete($id)
    {
        $id = request('id');
        $check = DB::table('floors')->where('id', $id)->delete();

        return redirect()->route('admin.floor.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data deleted successfully' : 'Failed to delete data'
            );
    }
}
