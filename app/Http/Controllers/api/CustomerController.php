<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Concessionaire;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ordenats per ordre d'inserció
        $customers = Customer::latest()->paginate(10);

        $response = [
            'success' => true,
            'message' => "Listado clientes recuperada",
            'data' => $customers,
        ];

        //return $response;
        return response()->json($response, 200);
    }

    public function all()
    {
        $customers = Customer::all();
        $response = [
            'success' => true,
            'message' => "Listado clientes recuperada",
            'data' => $customers,
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

        // [ "name"=>"customers", .......]
        $customer = Customer::create($input);

        $response = [
            'success' => true,
            'message' => "Cliente creado correctamente",
            'data' => $customer,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);

        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $response = [
            'success' => true,
            'message' => "Cliente encontrado",
            'data' => $customer,
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
        $customer = Customer::find($id);

        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
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

        $customer->update($input);

        $response = [
            'success' => true,
            'message' => "Cliente actualizado correctamente",
            'data' => $customer,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        try {
            $customer->delete();

            $response = [
                'success' => true,
                'message' => "Cliente borrado",
                'data' => $customer,
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            $response = [
                'success' => false,
                'message' => "Error borrando Cliente",
            ];

            return response()->json($response, 400);
        }
    }

    public function editConcessionaires(Customer $customer)
    {
        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $arrayId = $customer->concessionaires->pluck('id');
        $concessionaires = Concessionaire::whereNotIn('id', $arrayId)->get();

        $response = [
            'success' => true,
            'message' => 'Concesionarios encontrados correctamente',
            'data' => [$customer, $concessionaires]
        ];

        return response()->json($response, 200);
    }

    public function attachConcessionaires(Request $request, Customer $customer)
    {
        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $request->validate([
            'concessionaires' => 'exists:concessionaires,id',
        ]);

        $customer->concessionaires()->attach($request->concessionaires);

        $response = [
            'success' => true,
            'message' => 'Concesionarios asignados correctamente',
            'data' => $customer,
        ];

        return response()->json($response, 200);
    }

    public function detachConcessionaires(Request $request, Customer $customer)
    {
        if ($customer == null) {
            $response = [
                'success' => false,
                'message' => "Cliente no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $request->validate([
            'concessionaires' => 'exists:concessionaires,id',
        ]);

        if ($request->has('concessionaires')) {
            $customer->concessionaires()->detach($request->concessionaires);
        }

        $response = [
            'success' => true,
            'message' => 'Concesionarios extraídos correctamente',
            'data' => $customer,
        ];

        return response()->json($response, 200);
    }
}
