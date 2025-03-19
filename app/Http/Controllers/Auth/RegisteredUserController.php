<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInvite;
use App\Models\UserRoles;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): RedirectResponse|View
    {
        try {
            $invite_code = request()->get('invite_code') ?? '';
            $user_count = UserRoles::count();
            if (!$invite_code && $user_count > 0) {
                return redirect(route('login', absolute: false))
                    ->with('error', 'You need to invite to create account.');
            }
            $invite = null;
            if ($invite_code)
                $invite = UserInvite::checkInviteCode($invite_code);

            return view('auth.register', compact('invite'));
        } catch (\Exception $e) {
            return redirect(route('login', absolute: false))
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $userRole = new UserRoles();
            $roleAdmin = Roles::where('priority', 100)->first();
            if (!$roleAdmin) {
                throw new \Exception('Admin role not found');
            } else {
                $isHasAdmin = UserRoles::where('role_id', $roleAdmin->id)->first();
                if (!$isHasAdmin) {
                    $userRole->role_id = $roleAdmin->id;
                    $userRole->user_id = $user->id;
                    $userRole->save();
                } else {
                    $invite_code = $request->invite_code;
                    if (!$invite_code) {
                        return redirect(route('login', absolute: false))
                            ->with('error', 'You need to invite to create account.');
                    }
                    $invite = UserInvite::checkInviteCode($invite_code);
                    if (!$invite) {
                        return redirect(route('login', absolute: false))
                            ->with('error', 'Invite not found.');
                    }
                    $userRole->role_id = $invite->role_id;
                    $userRole->user_id = $user->id;
                    $userRole->save();

                    $invite->is_used = 1;
                    $invite->used_at = now();
                    $invite->save();
                }
            }



            DB::commit();



            event(new Registered($user));

            Auth::login($user);

            return redirect(route('admin.reservation.index', absolute: false));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
