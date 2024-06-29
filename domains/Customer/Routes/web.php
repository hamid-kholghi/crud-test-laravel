<?php

use Domains\Customer\Http\Controllers\Web\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::resource('/customers', CustomerController::class);
});
