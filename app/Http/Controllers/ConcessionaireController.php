<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concessionaire;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Customer;

class ConcessionaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $concessionaires = Concessionaire::all();

        return view('concessionaires.index', compact('concessionaires'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("concessionaires.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:concessionaires,name|max:75',
            'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
            'email' => 'required|max:40',
            'address' => 'required|max:75',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Almacenar la imagen
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('concessionaires'); // Almacena la imagen en una carpeta 'concessionaires'
        } else {
            $imagePath = null; // Si no se proporciona una imagen
        }

        $concessionaire = new Concessionaire;
        $concessionaire->name = $request->name;
        $concessionaire->phone_number = $request->phone_number;
        $concessionaire->email = $request->email;
        $concessionaire->address = $request->address;
        $concessionaire->coordinates = $request->coordinates;
        $concessionaire->picture = $imagePath;
        $concessionaire->save();

        return redirect()->route('concessionaires.index')
            ->with('success', 'Concesionario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $concessionaire = Concessionaire::findOrFail($id);

        return view('concessionaires.show', compact('concessionaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $concessionaire = Concessionaire::findOrFail($id);
        return view('concessionaires.edit', compact('concessionaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:75',
            'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
            'email' => 'required|max:40',
            'address' => 'required|max:75',
            'picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Almacenar la imagen
        if ($request->hasFile('picture')) {
            $imagePath = $request->file('picture')->store('concessionaires'); // Almacena la imagen en una carpeta 'concessionaires'
        } else {
            $imagePath = null; // Si no se proporciona una imagen
        }

        $concessionaire = Concessionaire::findOrFail($id);
        $concessionaire->name = $request->name;
        $concessionaire->phone_number = $request->phone_number;
        $concessionaire->email = $request->email;
        $concessionaire->address = $request->address;
        $concessionaire->coordinates = $request->coordinates;
        $concessionaire->picture = $imagePath;
        $concessionaire->save();

        return redirect()->route('concessionaires.index')
            ->with('success', 'Concesionario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concessionaire = Concessionaire::findOrFail($id);

        try {
            $result = $concessionaire->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('concessionaires.index')
                ->with('error', 'Error borrando el concesionario');
        }
        return redirect()->route('concessionaires.index')
            ->with('success', 'Concesionario borrado correctamente.');
    }

    public function editVehicles(Concessionaire $concessionaire)
    {
        // Transformem la col·lecció de vehicles en un array amb els id's
        $arrayId = $concessionaire->vehicles->pluck('id'); // exemple: [1,3,5]

        $vehicles = Vehicle::whereNotIn('id', $arrayId)->get();

        return view('concessionaires.showVehicles', compact('concessionaire', 'vehicles'));
    }

    public function addVehicles(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'vehicles' => 'exists:vehicles,id',
        ]);

        $concessionaire->vehicles()->saveMany(Vehicle::whereIn('id', $request->vehicles)->get());

        return redirect()->route('concessionaires.editVehicles', $concessionaire->id)
            ->with('success', 'Vehiculos asignados correctamente');
    }

    public function editEmployees(Concessionaire $concessionaire)
    {
        $arrayId = $concessionaire->employees->pluck('id');

        $employees = Employee::whereNotIn('id', $arrayId)->get();

        return view('concessionaires.showEmployees', compact('concessionaire', 'employees'));
    }

    public function addEmployees(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'employees' => 'exists:employees,id',
        ]);

        $concessionaire->employees()->saveMany(Employee::whereIn('id', $request->employees)->get());

        return redirect()->route('concessionaires.editEmployees', $concessionaire->id)
            ->with('success', 'Vehiculos asignados correctamente');
    }

    public function editCustomers(Concessionaire $concessionaire)
    {
        $arrayId = $concessionaire->customers->pluck('id');

        $customers = Customer::whereNotIn('id', $arrayId)->get();

        return view('concessionaires.showCustomers', compact('concessionaire', 'customers'));
    }

    public function attachCustomers(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'customers' => 'exists:customers,id',
        ]);

        $concessionaire->customers()->attach($request->customers);

        return redirect()->route('concessionaires.editCustomers', $concessionaire->id)
            ->with('success', 'Clientes asignados correctamente');
    }


    public function detachCustomers(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'customers' => 'exists:customers,id',
        ]);

        if ($request->has('customers'))
            $concessionaire->customers()->detach($request->customers);

        return redirect()->route('concessionaires.editCustomers', $concessionaire->id)
            ->with('success', 'Clientes extraidos correctamente');
    }
}
