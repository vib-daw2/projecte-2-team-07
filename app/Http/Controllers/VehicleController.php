<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Concessionaire;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $concessionaires = Concessionaire::pluck('name', 'id');
        return view("vehicles.create", compact('concessionaires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:vehicles,name|max:75',
            'model' => 'required',
            'price' => 'required|max:11',
            'motor' => 'required|max:75',
            'production_year' => 'required',
        ]);

        // Almacenar la imagen
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('concessionaires'); // Almacena la imagen en una carpeta 'concessionaires'
        } else {
            $imagePath = null; // Si no se proporciona una imagen
        }

        $vehicle = new Vehicle;
        $vehicle->name = $request->name;
        $vehicle->model = $request->model;
        $vehicle->fuel = $request->fuel;
        $vehicle->price = $request->price;
        $vehicle->motor = $request->motor;
        $vehicle->production_year = $request->production_year;
        $vehicle->picture = $imagePath;
        $vehicle->concessionaire_id = $request->concessionaire_id;
        $vehicle->save();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehiculo creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $concessionaires = Concessionaire::whereHas('vehicles', function ($query) use ($vehicle) {
            $query->where('name', $vehicle->name);
        })->get();

        if (Auth::check() && Auth::user()->is_employee) {
            $customers = Customer::pluck('name', 'id');
            return view('vehicles.show', compact('vehicle', 'concessionaires', 'customers'));
        }

        return view('vehicles.show', compact('vehicle', 'concessionaires'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $concessionaires = Concessionaire::pluck('name', 'id');
        $vehicle = vehicle::findOrFail($id);
        return view('vehicles.edit', compact('vehicle', 'concessionaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:75',
            'model' => 'required',
            'price' => 'required|max:11',
            'motor' => 'required|max:75',
            'production_year' => 'required',
        ]);

        // Almacenar la imagen
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('concessionaires'); // Almacena la imagen en una carpeta 'concessionaires'
        } else {
            $imagePath = null; // Si no se proporciona una imagen
        }

        $vehicle = Vehicle::findOrFail($id);
        $vehicle->name = $request->name;
        $vehicle->model = $request->model;
        $vehicle->fuel = $request->fuel;
        $vehicle->price = $request->price;
        $vehicle->motor = $request->motor;
        $vehicle->production_year = $request->production_year;
        $vehicle->picture = $imagePath;
        $vehicle->concessionaire_id = $request->concessionaire_id;
        $vehicle->save();

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehiculo actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        try {
            $result = $vehicle->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('vehicles.index')
                ->with('error', 'Error borrando el vehiculo');
        }
        return redirect()->route('vehicles.index')
            ->with('success', 'Vehiculo borrado correctamente.');
    }
}
