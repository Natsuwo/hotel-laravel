<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;




Route::middleware('role:manager')->group(function () {
  Route::resource('admin/invoice', InvoiceController::class)->names('admin.invoice');
  Route::resource('admin/transaction', TransactionController::class)->names('admin.transaction');
  Route::resource('admin/expense', ExpenseController::class)->names('admin.expense');
});
