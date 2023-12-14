<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ordenats per ordre d'inserció
        $employees = Employee::latest()->paginate(10);

        $response = [
            'success' => true,
            'message' => "Listado Empleados recuperada",
            'data' => $employees,
        ];

        //return $response;
        return response()->json($response, 200);
    }

    public function all()
    {
        $employees = Employee::all();
        $response = [
            'success' => true,
            'message' => "Listado Empleados recuperada",
            'data' => $employees,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // validar camps
         $input = $request->all();

         $validator = Validator::make(
             $input,
             [
                 'name' => 'required|min:3|max:70',
             ]
         );
 
         if ($validator->fails()) {
             $response = [
                 'success' => false,
                 'message' => "Errors de validació",
                 'data' => $validator->errors()->all(),
             ];
 
             return response()->json($response, 400);
         }
 
         // [ "name"=>"employees", .......]
         $employee = Employee::create($input);
 
         $response = [
             'success' => true,
             'message' => "Empleado creado correctamente",
             'data' => $employee,
         ];
 
         return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        if ($employee == null) {
            $response = [
                'success' => false,
                'message' => "Empleado no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => "Empleado encontrado",
            'data' => $employee,
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);

        if ($employee == null) {
            $response = [
                'success' => false,
                'message' => "Empleado no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'name' => 'required|min:3|max:70',
            ]
        );

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => "Errores de validación",
                'data' => $validator->errors()->all(),
            ];

            return response()->json($response, 400);
        }

        $employee->update($input);

        $response = [
            'success' => true,
            'message' => "Empleado actualizado correctamente",
            'data' => $employee,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if ($employee == null) {
            $response = [
                'success' => false,
                'message' => "Empleado no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        try {
            $employee->delete();

            $response = [
                'success' => true,
                'message' => "Empleado borrado",
                'data' => $employee,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'message' => "Error borrando Empleado",
            ];

            return response()->json($response, 400);
        }
    }
}
