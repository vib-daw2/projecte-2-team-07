<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('home');
});

Route::get('/concessionaires/api/index', function () {
    return view('concessionaires.api.index');
})->name('comncessionaires-api');

Route::get('/vehicles/api/index', function () {
    return view('vehicles.api.index');
})->name('vehicles-api');

Route::view('/privacy', 'auth.privacy-policy')->name('auth.privacy-policy');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::group(['middleware'=>'auth'], function() {

    Route::group(['middleware'=>['auth','is_employee']], function() {
    
        //Customers
        Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index'])
            ->name('customers.index');
        
        Route::get('/customers/show/{id}', [App\Http\Controllers\CustomerController::class, 'show'])
            ->name('customers.show');
        
        Route::get('/customers/destroy/{id}', [App\Http\Controllers\CustomerController::class, 'destroy'])
            ->name('customers.destroy');
        
        Route::get('/customers/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])
            ->name('customers.edit');
        
        Route::post('/customers/update/{id}', [App\Http\Controllers\CustomerController::class, 'update'])
            ->name('customers.update');

        //Vehicles    
        Route::get('/vehicles/create', [App\Http\Controllers\VehicleController::class, 'create'])
            ->name('vehicles.create');

        Route::post('/vehicles/store', [App\Http\Controllers\VehicleController::class, 'store'])
            ->name('vehicles.store');

        Route::get('/vehicles/destroy/{id}', [App\Http\Controllers\VehicleController::class, 'destroy'])
            ->name('vehicles.destroy');

        Route::get('/vehicles/edit/{id}', [App\Http\Controllers\VehicleController::class, 'edit'])
            ->name('vehicles.edit');

        Route::post('/vehicles/update/{id}', [App\Http\Controllers\VehicleController::class, 'update'])
            ->name('vehicles.update');
    });
   
    Route::group(['middleware'=>['auth','is_admin']], function() {
        
        //Employees
        Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])
            ->name('employees.index');

        Route::get('/employees/show/{id}', [App\Http\Controllers\EmployeeController::class, 'show'])
            ->name('employees.show');

        Route::get('/employees/create', [App\Http\Controllers\EmployeeController::class, 'create'])
            ->name('employees.create');

        Route::post('/employees/store', [App\Http\Controllers\EmployeeController::class, 'store'])
            ->name('employees.store');

        Route::get('/employees/destroy/{id}', [App\Http\Controllers\EmployeeController::class, 'destroy'])
            ->name('employees.destroy');

        Route::get('/employees/edit/{id}', [App\Http\Controllers\EmployeeController::class, 'edit'])
            ->name('employees.edit');

        Route::post('/employees/update/{id}', [App\Http\Controllers\EmployeeController::class, 'update'])
            ->name('employees.update');

        //Concessionaires    
        Route::get('/concessionaires/create', [App\Http\Controllers\ConcessionaireController::class, 'create'])
            ->name('concessionaires.create');
        
        Route::post('/concessionaires/store', [App\Http\Controllers\ConcessionaireController::class, 'store'])
            ->name('concessionaires.store');
        
        Route::get('/concessionaires/destroy/{id}', [App\Http\Controllers\ConcessionaireController::class, 'destroy'])
            ->name('concessionaires.destroy');
        
        Route::get('/concessionaires/edit/{id}', [App\Http\Controllers\ConcessionaireController::class, 'edit'])
            ->name('concessionaires.edit');
        
        Route::post('/concessionaires/update/{id}', [App\Http\Controllers\ConcessionaireController::class, 'update'])
            ->name('concessionaires.update');

        //Users
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])
            ->name('users.index');

        Route::get('/users/show/{id}', [App\Http\Controllers\UserController::class, 'show'])
            ->name('users.show');

        Route::get('/users/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroy'])
            ->name('users.destroy');

        Route::get('/users/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])
            ->name('users.edit');

        Route::post('/users/update/{id}', [App\Http\Controllers\UserController::class, 'update'])
            ->name('users.update');

        //Concessionaires - Vehicles
        Route::get('/concessionaires/{concessionaire}/vehicles', [App\Http\Controllers\ConcessionaireController::class, 'editVehicles'])->name('concessionaires.editVehicles');

        Route::post('/concessionaires/{concessionaire}/addVehicles', [App\Http\Controllers\ConcessionaireController::class, 'addVehicles'])->name('concessionaires.addVehicles');

        //Concessionaires - Employees
        Route::get('/concessionaires/{concessionaire}/employees', [App\Http\Controllers\ConcessionaireController::class, 'editEmployees'])->name('concessionaires.editEmployees');

        Route::post('/concessionaires/{concessionaire}/addEmployees', [App\Http\Controllers\ConcessionaireController::class, 'addEmployees'])->name('concessionaires.addEmployees');

        //Concessionaires - Customers
        Route::get('/concessionaires/{concessionaire}/customers', [App\Http\Controllers\ConcessionaireController::class, 'editCustomers'])->name('concessionaires.editCustomers');

        Route::post('/concessionaires/{concessionaire}/attachCustomers', [App\Http\Controllers\ConcessionaireController::class, 'attachCustomers'])->name('concessionaires.attachCustomers');

        Route::post('/concessionaires/{concessionaire}/detachCustomers', [App\Http\Controllers\ConcessionaireController::class, 'detachCustomers'])->name('concessionaires.detachCustomers');

        // Customers - Concessionaires
        Route::get('/customers/{customer}/concessionaires', [App\Http\Controllers\CustomerController::class, 'editConcessionaires'])->name('customers.editConcessionaires');

        Route::post('/customers/{customer}/attachConcessionaires', [App\Http\Controllers\CustomerController::class, 'attachConcessionaires'])->name('customers.attachConcessionaires');

        Route::post('/customers/{customer}/detachConcessionaires', [App\Http\Controllers\CustomerController::class, 'detachConcessionaires'])->name('customers.detachConcessionaires');
    });

    //Sales
    Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])
    ->name('sales.index');

    Route::get('/sales/show/{id}', [App\Http\Controllers\SaleController::class, 'show'])
    ->name('sales.show');

    Route::get('/sales/create', [App\Http\Controllers\SaleController::class, 'create'])
    ->name('sales.create');

    Route::post('/sales/store', [App\Http\Controllers\SaleController::class, 'store'])
    ->name('sales.store');

    Route::get('/sales/destroy/{id}', [App\Http\Controllers\SaleController::class, 'destroy'])
    ->name('sales.destroy');

    Route::get('/sales/edit/{id}', [App\Http\Controllers\SaleController::class, 'edit'])
    ->name('sales.edit');

    Route::post('/sales/update/{id}', [App\Http\Controllers\SaleController::class, 'update'])
    ->name('sales.update');
});

//Concessionaires
Route::get('/concessionaires', [App\Http\Controllers\ConcessionaireController::class, 'index'])
    ->name('concessionaires.index');

Route::get('/concessionaires/show/{id}', [App\Http\Controllers\ConcessionaireController::class, 'show'])
    ->name('concessionaires.show');

//Vehicles
Route::get('/vehicles', [App\Http\Controllers\VehicleController::class, 'index'])
    ->name('vehicles.index');

Route::get('/vehicles/show/{id}', [App\Http\Controllers\VehicleController::class, 'show'])
    ->name('vehicles.show');

Route::view('/location', 'location')->name('location');

Route::get('/customers/create', [App\Http\Controllers\CustomerController::class, 'create'])
->name('customers.create');

Route::post('/customers/store', [App\Http\Controllers\CustomerController::class, 'store'])
->name('customers.store');

Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])
->name('users.create');

Route::post('/users/store', [App\Http\Controllers\UserController::class, 'store'])
->name('users.store');