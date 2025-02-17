<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
