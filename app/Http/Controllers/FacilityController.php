<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends Controller
{
    public function index()
    {
        $perPage = 10;
        $records = DB::table('facilities')->paginate($perPage);
        return view('admin.pages.facility.index', [
            'records' => $records,
        ]);
    }

    public function create()
    {
        return view('admin.pages.facility.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
        ]);

        DB::table('facilities')->insert([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.facility.index')
            ->with('success', 'Facility created successfully');
    }

    public function edit($id)
    {
        $record = DB::table('facilities')->where('id', $id)->first();
        return view('admin.pages.facility.edit', [
            'record' => $record,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string',
        ]);

        $check = DB::table('facilities')->where('id', $id)->update([
            'name' => $request->name,
            'icon' => $request->icon,
        ]);

        return redirect()->route('admin.facility.index')
            ->with(
                $check ? 'message' : 'error',
                $check ? 'Data updated successfully' : 'Failed to update data'
            );
    }

    public function destroy($id)
    {
        DB::table('facilities')->where('id', $id)->delete();
        return redirect()->route('admin.facility.index')
            ->with('success', 'Facility deleted successfully');
    }
}
