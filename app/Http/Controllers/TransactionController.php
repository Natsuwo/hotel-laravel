<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = 10;
        $transactions = Transaction::orderBy('transaction_date', 'desc')->paginate($perPage);
        return view('admin.pages.transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.transaction.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $check = Transaction::create([
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.transaction.index')->with(
            $check ? 'success' : 'error',
            $check ? 'Transaction created successfully' : 'Failed to create transaction'
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
        $record = Transaction::find($id);
        return view('admin.pages.transaction.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $check = Transaction::find($id)->update([
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'description' => $request->description,
        ]);
        return redirect()->route('admin.transaction.index')->with(
            $check ? 'success' : 'error',
            $check ? 'Transaction updated successfully' : 'Failed to update transaction'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $check = Transaction::destroy($id);
        return redirect()->route('admin.transaction.index')->with(
            $check ? 'success' : 'error',
            $check ? 'Transaction deleted successfully' : 'Failed to delete transaction'
        );
    }
}
