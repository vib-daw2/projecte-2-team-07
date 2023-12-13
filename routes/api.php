<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/concessionaires/all', [App\Http\Controllers\api\ConcessionaireController::class, 'all'])->name('concessionaires.all');

Route::resource('/concessionaires', App\Http\Controllers\api\ConcessionaireController::class);

Route::get('/concessionaires/{concessionaire}/edit-customers', [App\Http\Controllers\api\ConcessionaireController::class, 'editCustomers']);
Route::post('/concessionaires/{concessionaire}/attach-customers', [App\Http\Controllers\api\ConcessionaireController::class, 'attachCustomers']);
Route::post('/concessionaires/{concessionaire}/detach-customers', [App\Http\Controllers\api\ConcessionaireController::class, 'detachCustomers']);

Route::get('/concessionaires/{concessionaire}/edit-employees', [App\Http\Controllers\api\ConcessionaireController::class, 'editEmployees']);
Route::post('/concessionaires/{concessionaire}/add-employees', [App\Http\Controllers\api\ConcessionaireController::class, 'addEmployees']);

Route::get('/concessionaires/{concessionaire}/edit-vehicles', [App\Http\Controllers\api\ConcessionaireController::class, 'editVehicles']);
Route::post('/concessionaires/{concessionaire}/add-vehicles', [App\Http\Controllers\api\ConcessionaireController::class, 'addVehicles']);

Route::get('/vehicles/all', [App\Http\Controllers\api\VehicleController::class, 'all'])->name('vehicles.all');

Route::resource('/vehicles', App\Http\Controllers\api\VehicleController::class);

Route::get('/customers/all', [App\Http\Controllers\api\CustomerController::class, 'all'])->name('customers.all');

Route::resource('/customers', App\Http\Controllers\api\CustomerController::class);