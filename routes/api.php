<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('client')->group(function(){
    Route::get('', 
        array(
            ClientController::class,
            'index'
        )
    )->name('client.index');

    Route::post('', 
        array(
            ClientController::class,
            'store'
        )
    )->name('client.store');

    Route::get('{client}', 
        array(
            ClientController::class,
            'show'
        )
    )->name('client.show');

    Route::put('{client}', 
        array(
            ClientController::class,
            'update'
        )
    )->name('client.update');

    Route::delete('{client}', 
        array(
            ClientController::class,
            'destroy'
        )
    )->name('client.destroy');

    Route::post('{client}/restore', 
        array(
            ClientController::class,
            'restore'
        )
    )->name('client.restore');
});
