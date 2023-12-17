<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Concessionaire;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class ConcessionaireController extends Controller
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
                'name' => 'required|unique:concessionaires,name|max:75',
                'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
                'email' => 'required|email|max:40',
                'address' => 'required|max:75',
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
            'message' => "Concessionario creado correctamente",
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
                'name' => 'required|max:75',
                'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
                'email' => 'required|email|max:40',
                'address' => 'required|max:75',
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

    public function editVehicles(Concessionaire $concessionaire)
    {
        $arrayId = $concessionaire->vehicles->pluck('id');
        $vehicles = Vehicle::whereNotIn('id', $arrayId)->get();

        $response = [
            'success' => true,
            'data' => [
                'concessionaire' => $concessionaire,
                'vehicles' => $vehicles,
            ],
        ];

        return response()->json($response, 200);
    }

    public function addVehicles(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'vehicles' => 'exists:vehicles,id',
        ]);

        $concessionaire->vehicles()->saveMany(Vehicle::whereIn('id', $request->vehicles)->get());

        $response = [
            'success' => true,
            'message' => 'Vehículos asignados correctamente',
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }

    public function editEmployees(Concessionaire $concessionaire)
    {
        $arrayId = $concessionaire->employees->pluck('id');

        $employees = Employee::whereNotIn('id', $arrayId)->get();

        $response = [
            'success' => true,
            'data' => [
                'concessionaire' => $concessionaire,
                'employees' => $employees,
            ],
        ];

        return response()->json($response, 200);
    }

    public function addEmployees(Request $request, Concessionaire $concessionaire)
    {
        $request->validate([
            'employees' => 'exists:employees,id',
        ]);

        $concessionaire->employees()->saveMany(Employee::whereIn('id', $request->employees)->get());

        $response = [
            'success' => true,
            'message' => 'Empleados asignados correctamente',
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }

    public function editCustomers(Concessionaire $concessionaire)
    {
        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concesionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $arrayId = $concessionaire->customers->pluck('id');
        $customers = Customer::whereNotIn('id', $arrayId)->get();

        $response = [
            'success' => true,
            'message' => 'Clientes encontrados correctamente',
            'data' => [$concessionaire, $customers]
        ];

        return response()->json($response, 200);
    }

    public function attachCustomers(Request $request, Concessionaire $concessionaire)
    {
        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concesionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $request->validate([
            'customers' => 'exists:customers,id',
        ]);

        $concessionaire->customers()->attach($request->customers);

        $response = [
            'success' => true,
            'message' => 'Clientes asignados correctamente',
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }

    public function detachCustomers(Request $request, Concessionaire $concessionaire)
    {
        if ($concessionaire == null) {
            $response = [
                'success' => false,
                'message' => "Concesionario no encontrado",
                'data' => [],
            ];

            return response()->json($response, 404);
        }

        $request->validate([
            'customers' => 'exists:customers,id',
        ]);

        if ($request->has('customers')) {
            $concessionaire->customers()->detach($request->customers);
        }

        $response = [
            'success' => true,
            'message' => 'Clientes extraídos correctamente',
            'data' => $concessionaire,
        ];

        return response()->json($response, 200);
    }
}
