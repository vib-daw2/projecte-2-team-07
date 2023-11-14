<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concessionaire;
use Illuminate\Support\Facades\Validator;

class ConcesionaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ordenats per ordre d'inserció
        $concessionaires = Concessionaire::latest()->paginate(10);

        $response = [
            'success' => true,
            'message' => "Listado concesionarios recuperada",
            'data' => $concessionaires,
        ];

        //return $response;
        return response()->json($response, 200);
    }

    public function all()

    {
        $concessionaires = Concessionaire::all();
        $response = [
            'success' => true,
            'message' => "Listado concesionarios recuperada",
            'data' => $concessionaires,
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

        // [ "name"=>"concessionairea1", .......]
        $concessionaire = Concessionaire::create($input);

        $response = [
            'success' => true,
            'message' => "concessionairea creat correctament",
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $concessionaire = Concessionaire::find($id);

        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concesionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => "Concesionario encontrado",
            'data' => $concessionaire,
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
        $concessionaire = Concessionaire::find($id);

        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concessionario no encontrado",
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

        $concessionaire->update($input);

        $response = [
            'success' => true,
            'message' => "Concesionario actualizado correctamente",
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $concessionaire = Concessionaire::find($id);

        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concessionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        try {
            $concessionaire->delete();

            $response = [
                'success' => true,
                'message' => "Concessionario borrado",
                'data' => $concessionaire,
            ];

            return response()->json($response, 200);

        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'message' => "Error borrando Concessionario",
            ];

            return response()->json($response, 400);
        }
    }
}
