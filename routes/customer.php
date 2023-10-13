<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

//Rutas clientes
Route::controller(CustomerController::class)->group(function (){
    Route::get('/dashboard-cliente', 'index')->middleware('can:Ver Menú Clientes')->name('dashboard-customer');
    Route::get('/lista_consulta_clientes', 'listarOrderCustomers');
    Route::get('/order/{order}','show');
});





