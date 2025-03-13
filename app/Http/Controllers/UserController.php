<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\UserRoles;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('userRole.role', 'meta')
            ->paginate(10);
        return view('admin.pages.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userRole = Auth::user()->roles()->first();
        $roles = Roles::where('priority', '<=', $userRole->priority)->get();
        return view('admin.pages.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $userRole = Auth::user()->roles()->first();
            $roleUpgrate = Roles::where('id', $request->role)->first();
            if ($roleUpgrate->priority > $userRole->priority) {
                throw new \Exception('You can not create a user with a higher role.');
            }

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required'],
            ]);

            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $userRole = new UserRoles();
            $userRole->user_id = $user->id;
            $userRole->role_id = $request->role;
            $userRole->save();

            foreach ($request->meta_key as $key => $value) {
                $userMeta = new UserMeta();
                $userMeta->user_id = $user->id;
                $userMeta->meta_key = $key;
                $userMeta->meta_value = $value;
                $userMeta->save();
            }

            DB::commit();

            return redirect()->route('admin.user.index');
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
        $user = User::with('userRole.role', 'meta')->find($id, ['id', 'name', 'email']);
        $adminRole = Roles::where('priority', 100)->first();
        $adminCount = UserRoles::where('role_id', $adminRole->id)->count();
        $userRole = Auth::user()->roles()->first();
        $roles = Roles::where('priority', '<=', $userRole->priority)->get();
        return view('admin.pages.user.edit', compact('user', 'roles', 'adminCount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'role' => 'required|exists:' . Roles::class . ',id',
            ]);



            $userRole = Auth::user()->roles()->first();
            $roleUpgrate = Roles::where('id', $request->role)->first();

            if ($roleUpgrate->priority > $userRole->priority) {
                throw new \Exception('You can not update a user with a higher role.');
            }



            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $userTargetRole = UserRoles::where('user_id', $id)->first();

            if ($userTargetRole->role->priority == 100 && $userRole->priority != 100) {
                $adminCount = UserRoles::where('role_id', 1)->count();
                if ($adminCount == 1) {
                    throw new \Exception('You need at least one admin user.');
                }
            }

            // UserRoles::where('user_id', $id)->update(['role_id' => $request->role]);
            $userTargetRole->role_id = $request->role;
            $userTargetRole->save();


            UserMeta::where('user_id', $id)->delete();
            foreach ($request->meta_key as $key => $value) {
                $userMeta = new UserMeta();
                $userMeta->user_id = $user->id;
                $userMeta->meta_key = $key;
                $userMeta->meta_value = $value;
                $userMeta->save();
            }

            DB::commit();

            return redirect()->route('admin.user.index');
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
        $adminRole = Roles::where('priority', 100)->first();
        $adminCount = UserRoles::where('role_id', $adminRole->id)->count();
        $userTargetRole = UserRoles::where('user_id', $id)->first();
        $userRole = Auth::user()->roles()->first();
        $user = Auth::user();
        $userTarget = User::find($id);


        if ($userTargetRole->role->priority == 100 && $userRole->priority != 100) {
            return redirect()->back()->with('error', 'You cannot delete an admin user.');
        }

        if ($userTargetRole->role->priority == $userRole->priority) {
            return redirect()->back()->with('error', 'You cannot delete a user with the same role.');
        }

        if ($userTargetRole->role->priority > $userRole->priority) {
            return redirect()->back()->with('error', 'You cannot delete a user with a higher role.');
        }

        if ($user->id == $userTarget->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        if ($adminCount == 1 && $userTargetRole->role_id == $adminRole->id) {
            return redirect()->back()->with('error', 'You need at least one admin user.');
        }

        if ($userRole->priority != 100) {
            return redirect()->back()->with('error', 'You cannot delete a user.');
        }

        User::destroy($id);
        return redirect()->route('admin.user.index');
    }
}
