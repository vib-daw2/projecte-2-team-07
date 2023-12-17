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
        $vehicles = Vehicle::latest()->paginate(10);

        $response = [
            'success' => true,
            'message' => "Listado vehiculos recuperada",
            'data' => $vehicles,
        ];

        //return $response;
        return response()->json($response, 200);
    }

    public function all()
    {
        $vehicles = Vehicle::all();
        $response = [
            'success' => true,
            'message' => "Listado vehiculos recuperada",
            'data' => $vehicles,
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
                'name' => 'required|unique:vehicles,name|max:75',
                'model' => 'required',
                'price' => 'required|max:11',
                'motor' => 'required|max:75',
                'production_year' => 'required',
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
                'message' => "Vehiculo no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => "Vehiculo encontrado",
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
        $vehicle = Vehicle::find($id);

        if ($vehicle == null) {
            $response = [
                'success' => false,
                'message' => "Vehiculo no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $input = $request->all();

        $validator = Validator::make(
            $input,
            [
                'name' => 'required|max:75',
                'model' => 'required',
                'price' => 'required|max:11',
                'motor' => 'required|max:75',
                'production_year' => 'required',
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

        $vehicle->update($input);

        $response = [
            'success' => true,
            'message' => "Vehiculo actualizado correctamente",
            'data' => $vehicle,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::find($id);

        if ($vehicle == null) {
            $response = [
                'success' => false,
                'message' => "Vehiculo no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        try {
            $vehicle->delete();

            $response = [
                'success' => true,
                'message' => "Vehiculo borrado",
                'data' => $vehicle,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'message' => "Error borrando Vehiculo",
            ];

            return response()->json($response, 400);
        }
    }
}
