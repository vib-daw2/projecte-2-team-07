<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ordenats per ordre d'inserció
        $vehicles = Vehicle::latest()->paginate(5);

        $response = [
            'success' => true,
            'message' => "Listado vehiculos recuperada",
            'data' => $vehicles,
        ];

        //return $response;
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
 
         // [ "name"=>"vehicles", .......]
         $vehicle = Vehicle::create($input);
 
         $response = [
             'success' => true,
             'message' => "Vehiculo creado correctamente",
             'data' => $vehicle,
         ];
 
         return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle == null) {
            $response = [
                'success' => false,
                'message' => "Concesionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => "Vehiculos encontrado",
            'data' => $vehicle,
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}