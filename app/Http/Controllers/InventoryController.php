<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\StoreRequest;
use App\Http\Requests\Inventory\UpdateRequest;
use App\Models\Inventory;
use App\Models\InventorySupplier;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $records = Inventory::with('gallery')
            ->select('*')
            ->selectRaw('reorder_level - stock_quantity + safety_stock as quantity_in_reorder')
            ->selectRaw('CASE 
                    WHEN stock_quantity = 0 THEN "out of stock" 
                    WHEN stock_quantity <= safety_stock THEN "low" 
                    ELSE "available" 
                 END as availability')
            ->orderBy('name')
            ->paginate($perPage);
        return view('admin.pages.inventory.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = InventorySupplier::orderBy('name')->get();
        return view('admin.pages.inventory.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $check =  Inventory::create([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'reorder_level' => $request->reorder_level,
            'safety_stock' => $request->safety_stock,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'gallery_id' => $request->gallery_id,
            'supplier_id' => $request->supplier_id,
        ]);

        return redirect()->route('admin.inventory.index')->with(
            $check ? 'success' : 'error',
            $check ? 'Inventory added successfully' : 'Failed to add inventory'
        );
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
        $record = Inventory::with('gallery', 'supplier')->find($id);
        $suppliers = InventorySupplier::orderBy('name')->get();
        return view('admin.pages.inventory.edit', compact('record', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $check = Inventory::find($id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'stock_quantity' => $request->stock_quantity,
            'reorder_level' => $request->reorder_level,
            'safety_stock' => $request->safety_stock,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'gallery_id' => $request->gallery_id,
            'supplier_id' => $request->supplier_id,
        ]);
        return redirect()->route('admin.inventory.index')->with(
            $check ? 'success' : 'error',
            $check ? 'Inventory updated successfully' : 'Failed to update inventory'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
