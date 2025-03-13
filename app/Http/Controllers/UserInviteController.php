<?php

namespace App\Http\Controllers;

use App\Jobs\SendMailInvite;
use App\Models\Roles;
use App\Models\UserInvite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserInviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = 10;
        $invites = UserInvite::with('role')->paginate($limit);
        return view('admin.pages.user.invite.index', compact('invites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all();
        $inviteCode = UserInvite::generateInviteCode();
        return view('admin.pages.user.invite.create', compact('roles', 'inviteCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'invite_code' => 'required:unique:user_invite',
                'email' => 'required|email',
                'role_id' => 'required|exists:roles,id',
                'expired_at' => 'required|date',
            ]);

            $invite =  UserInvite::create([
                'invite_code' => $request->invite_code,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'expired_at' => $request->expired_at,
            ]);

            SendMailInvite::dispatch($request->email, $invite);

            DB::commit();

            return redirect()->route('admin.user_invite.index')
                ->with('success', 'Invite created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $roles = Roles::all();
        $invite = UserInvite::findOrFail($id);
        return view('admin.pages.user.invite.edit', compact('roles', 'invite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'email' => 'required|email',
                'role_id' => 'required|exists:roles,id',
                'expired_at' => 'required|date',
            ]);

            $invite = UserInvite::findOrFail($id);
            $invite->update([
                'email' => $request->email,
                'role_id' => $request->role_id,
                'expired_at' => $request->expired_at,
            ]);

            DB::commit();

            return redirect()->route('admin.user_invite.index')
                ->with('success', 'Invite updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $invite = UserInvite::findOrFail($id);
        $invite->delete();
        return redirect()->route('admin.user_invite.index')
            ->with('success', 'Invite deleted successfully');
    }
}
