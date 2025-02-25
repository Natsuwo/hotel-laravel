<?php

namespace App\Http\Controllers;

use App\Models\GuestMemberShips;
use App\Models\GuestTierLevel;
use Illuminate\Http\Request;

class GuestMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $records = GuestMemberShips::orderBy('point_required', 'asc')->paginate(10);
        return view('admin.pages.guest_membership.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.guest_membership.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:guest_memberships',
            'discount' => 'numeric',
            'spending_required' => 'required|numeric',
            'point_required' => 'required|numeric',
        ]);


        $check = GuestMemberShips::create([
            'name' => $request->name,
            'discount' => $request->discount,
            'spending_required' => $request->spending_required,
            'point_required' => $request->point_required,
        ]);
        return redirect()->route('admin.guest_membership.index')
            ->with($check ? ['success' => 'Guest Membership Created Successfully'] : ['error' => 'Error Creating Guest Membership']);
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
        $record = GuestMemberShips::find($id);
        return view('admin.pages.guest_membership.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:guest_memberships,name,' . $id,
            'discount' => 'numeric',
            'spending_required' => 'required|numeric',
            'point_required' => 'required|numeric',
        ]);

        $check = GuestMemberShips::find($id)->update([
            'name' => $request->name,
            'discount' => $request->discount,
            'spending_required' => $request->spending_required,
            'point_required' => $request->point_required,
        ]);
        return redirect()->route('admin.guest_membership.index')
            ->with($check ? ['success' => 'Guest Membership Updated Successfully'] : ['error' => 'Error Updating Guest Membership']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = GuestMemberShips::find($id)->delete();
        return redirect()->route('admin.guest_membership.index')
            ->with($check ? ['success' => 'Guest Membership Deleted Successfully'] : ['error' => 'Error Deleting Guest Membership']);
    }
}
