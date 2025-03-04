<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventorySupplier;
use Illuminate\Http\Request;

class InventorySupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perpage = 10;
        $suppliers = InventorySupplier::orderBy('name')
            ->paginate($perpage);
        return view('admin.pages.inventory_supplier.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.inventory_supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        InventorySupplier::create([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ]);
        return redirect()->route('admin.inventory_supplier.index')
            ->with('success', 'Supplier created successfully.');
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
        $record = InventorySupplier::find($id);
        return view('admin.pages.inventory_supplier.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $check = InventorySupplier::find($id)->update([
            'name' => $request['name'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'email' => $request['email'],
        ]);

        return redirect()->route('admin.inventory_supplier.index')
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Supplier updated successfully.' : 'Error updating supplier.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = InventorySupplier::destroy($id);

        return redirect()->route('admin.inventory_supplier.index')
            ->with(
                $check ? 'success' : 'error',
                $check ? 'Supplier deleted successfully.' : 'Error deleting supplier.'
            );
    }
}
