<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\RoleStoreRequest;
use App\Models\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $limit = 10;
        $roles = Roles::paginate($limit);
        return view('admin.pages.user.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.user.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleStoreRequest $request)
    {
        $role = new Roles();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->is_active = $request->is_active;
        $role->priority = $request->priority;
        $role->save();
        return redirect()->route('admin.roles.index');
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
        $role = Roles::find($id);
        return view('admin.pages.user.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Roles::find($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->is_active = $request->is_active;
        $role->priority = $request->priority;
        $role->save();
        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Roles::destroy($id);
        return redirect()->route('admin.roles.index');
    }
}
