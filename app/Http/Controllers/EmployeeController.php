<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Concessionaire;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Recuperem una col·lecció amb tots els treballadors de la BD
        $employees = Employee::all();

        // Carreguem la vista employees/index.blade.php 
        // i li passem la llista de treballadors
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $concessionaires = Concessionaire::pluck('name','id');
        return view("employees.create", compact('concessionaires'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validació dels camps
        $request->validate([
            'name' => 'required|max:75',
            'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
            'email' => 'required|email|max:40',
            'address' => 'required|max:75',
            'dni' => 'required|regex:/^[XYZ]?\d{7,8}[A-Z]$/|max:10',
            'charge' => 'required',
            'department' => 'required',
            'concessionaire_id' => 'required',
        ]);
        
        $employee = new Employee;
        $employee->name = $request->name;
        $employee->phone_number = $request->phone_number;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->dni = $request->dni;
        $employee->charge = $request->charge;
        $employee->department = $request->department;
        $employee->concessionaire_id = $request->concessionaire_id;
        $employee->save();

        return redirect()->route('employees.index')
            ->with('success','Empleado creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Obtenim un objecte Employee a partir del seu id
        $employee = Employee::findOrFail($id);
        // Carreguem la vista i li passem el employee que volem visualitzar
        return view('employees.show',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $concessionaires = Concessionaire::pluck('name','id');
        $employee = Employee::findOrFail($id);
        return view('employees.edit',compact('employee','concessionaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         // Validació dels camps
         $request->validate([
            'name' => 'required|max:75',
            'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
            'email' => 'required|email|max:40',
            'address' => 'required|max:75',
            'dni' => 'required|regex:/^[XYZ]?\d{7,8}[A-Z]$/|max:10',
            'charge' => 'required',
            'department' => 'required',
            'concessionaire_id' => 'required',
        ]);

        $employee = Employee::findOrFail($id);
        $employee->name = $request->name;
        $employee->phone_number = $request->phone_number;
        $employee->email = $request->email;
        $employee->address = $request->address;
        $employee->dni = $request->dni;
        $employee->charge = $request->charge;
        $employee->department = $request->department;
        $employee->concessionaire_id = $request->concessionaire_id;
        $employee->save();
    
        return redirect()->route('employees.index')
                        ->with('success','Empleado actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Obtenim el treballador que volem esborrar
        $employee = Employee::findOrFail($id);
        // Intentem esborrar-lo, En cas que un concessionari tingui aquest treballador assignat
        // es produiria un error en l'esborrat!!!!
        try {
            $result = $employee->delete();
        }
        catch(\Illuminate\Database\QueryException $e) {
                return redirect()->route('employees.index')
                        ->with('error','Error borrando el empleado');
        }   
        return redirect()->route('employees.index')
                        ->with('success','Empleado borrado correctamente.'); 
    }
}
