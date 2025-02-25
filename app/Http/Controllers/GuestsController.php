<?php

namespace App\Http\Controllers;

use App\Http\Requests\Guest\StoreRequest;
use App\Http\Requests\Guest\UpdateRequest;
use App\Models\Guests;
use Illuminate\Http\Request;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = request()->query('perpage', 10);
        $guests = Guests::leftJoin(
            'guest_memberships',
            function ($join) {
                $join->on('guests.point', '>=', 'guest_memberships.point_required')
                    ->whereRaw('guest_memberships.point_required = (select max(point_required) from guest_memberships where guests.point >= point_required)');
            }
        )->select(
            'guests.*',
            'guest_memberships.name as membership_name'
        )->paginate($perpage);

        return view('admin.pages.guest.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.guest.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $guest = Guests::create([
            'uid' => $request->uid,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nationality' => $request->nationality,
            'passport' => $request->passport,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);

        return redirect()->route('admin.guest.index')->with('success', 'Guest created successfully.');
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
        $record = Guests::find($id);
        return view('admin.pages.guest.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $guest = Guests::find($id);
        $guest->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'nationality' => $request->nationality,
            'passport' => $request->passport,
            'gender' => $request->gender,
            'dob' => $request->dob,
        ]);

        return redirect()->route('admin.guest.index')
            ->with($guest ? ['success' => 'Guest updated successfully.'] : ['error' => 'Error updating guest.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guests::find($id);
        $guest->delete();
        return redirect()->route('admin.guest.index')
            ->with($guest ? ['success' => 'Guest deleted successfully.'] : ['error' => 'Error deleting guest.']);
    }

    public function makeUid()
    {
        $uid = Guests::generateUid();
        return response()->json(['uid' => $uid]);
    }

    public function getGuests(Request $request)
    {
        $guests = Guests::where('name', 'like', '%' . $request->name . '%')
            ->orWhere('email', 'like', '%' . $request->name . '%')
            ->orWhere('phone', 'like', '%' . $request->name . '%')
            ->orWhere('passport', 'like', '%' . $request->name . '%')
            ->orWhere('uid', 'like', '%' . $request->name . '%')
            ->get();
        return response()->json($guests);
    }
}
