<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\EmployeeController;
use App\Http\Controllers\api\ConcessionaireController;
use App\Http\Controllers\api\VehicleController;
use App\Http\Controllers\api\CustomerController;

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

Route::middleware(['auth:sanctum', 'checkUserRole'])->group(function () {

    // Rutas accesibles para todos los roles
    Route::get('/common-route', function () {
        return response()->json('This route is accessible to all roles', 200);
    });

    // Grupo de rutas accesibles solo para el rol 'admin'
    Route::middleware(['auth:sanctum', 'checkUserRole:admin'])->group(function () {

        Route::get('/admin-only-route', function () {
            return response()->json('This route is accessible only to admin', 200);
        });

        // Rutas específicas para el rol de administrador
        Route::get('/employees/all', [EmployeeController::class, 'all'])->name('employees.all');
        Route::resource('/employees', EmployeeController::class);

        Route::get('/vehicles/all', [VehicleController::class, 'all'])->name('vehicles.all');
        Route::resource('/vehicles', VehicleController::class);
    });

    // Grupo de rutas accesibles solo para el rol 'employee'
    Route::middleware(['auth:sanctum', 'checkUserRole:employee'])->group(function () {

        Route::get('/employee-only-route', function () {
            return response()->json('This route is accessible only to employee', 200);
        });

        // Rutas específicas para el rol de empleado
        Route::get('/concessionaires/all', [ConcessionaireController::class, 'all'])->name('concessionaires.all');
        Route::resource('/concessionaires', ConcessionaireController::class);

        Route::get('/concessionaires/{concessionaire}/edit-customers', [ConcessionaireController::class, 'editCustomers']);
        Route::post('/concessionaires/{concessionaire}/attach-customers', [ConcessionaireController::class, 'attachCustomers']);
        Route::post('/concessionaires/{concessionaire}/detach-customers', [ConcessionaireController::class, 'detachCustomers']);

        Route::get('/concessionaires/{concessionaire}/edit-employees', [ConcessionaireController::class, 'editEmployees']);
        Route::post('/concessionaires/{concessionaire}/add-employees', [ConcessionaireController::class, 'addEmployees']);

        Route::get('/concessionaires/{concessionaire}/edit-vehicles', [ConcessionaireController::class, 'editVehicles']);
        Route::post('/concessionaires/{concessionaire}/add-vehicles', [ConcessionaireController::class, 'addVehicles']);

        Route::get('/customers/all', [CustomerController::class, 'all'])->name('customers.all');
        Route::resource('/customers', CustomerController::class);

        Route::get('/customers/{customer}/edit-concessionaires', [CustomerController::class, 'editConcessionaires']);
        Route::post('/customers/{customer}/attach-concessionaires', [CustomerController::class, 'attachConcessionaires']);
        Route::post('/customers/{customer}/detach-concessionaires', [CustomerController::class, 'detachConcessionaires']);
    });
});
