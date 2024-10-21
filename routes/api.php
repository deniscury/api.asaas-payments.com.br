<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvoiceController;
use App\Models\Invoice;
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

Route::prefix('invoice')->group(function(){
    Route::get('', 
        array(
            InvoiceController::class,
            'index'
        )
    )->name('invoice.index');

    Route::get('/{invoice}', 
        array(
            InvoiceController::class,
            'show'
        )
    )->name('invoice.show');

    Route::get('client/{client}', 
        array(
            InvoiceController::class,
            'index'
        )
    )->name('invoice.index');

    Route::post('client/{client}', 
        array(
            InvoiceController::class,
            'payment'
        )
    )->name('invoice.payment');

    Route::get('{invoice}/pix', 
        array(
            InvoiceController::class,
            'pix'
        )
    )->name('invoice.pix');

    Route::get('{invoice}/bill', 
        array(
            InvoiceController::class,
            'bill'
        )
    )->name('invoice.bill');

    Route::post('{invoice}/credit-card', 
        array(
            InvoiceController::class,
            'creditCard'
        )
    )->name('invoice.creditCard');

    Route::get('{invoice}/money', 
        array(
            InvoiceController::class,
            'money'
        )
    )->name('invoice.money');
});