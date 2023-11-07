<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::all();
        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::pluck('name', 'id');
        $vehicles = Vehicle::pluck('name', 'id', 'price');
        return view("sales.create", compact('customers', 'vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->is_employee) {
            $customer_id = $request->input('customer_id');
            $customer = Customer::where('id', $customer_id)->firstOrFail();
        } else {
            $user_id = Auth::id();
            $customer = Customer::where('user_id', $user_id)->firstOrFail();
            $customer_id = $customer->id;
        }

        $vehicle = Vehicle::where('concessionaire_id', $request->input('concessionaire_id'))
        ->where('name', $request->input('vehicle_name'))
        ->firstOrFail();

        $sale = new Sale;
        $sale->date = now();
        $sale->amount = $request->vehicle_price;
        $sale->customer_id = $customer_id;
        $sale->vehicle_id = $vehicle->id;
        $sale->concessionaire_id = $request->input('concessionaire_id');
        $sale->save();

        $vehicle->concessionaire_id = null;
        $vehicle->save();

        if (!$customer->concessionaires->contains($request->input('concessionaire_id'))) {
            $customer->concessionaires()->attach($request->input('concessionaire_id'));
        }

        return redirect()->route('vehicles.index')
            ->with('success', 'Venta creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customers = Customer::pluck('name', 'id');
        $vehicles = Vehicle::pluck('name', 'id', 'price');
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale', 'customers', 'vehicles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required',
            'amount' => 'required',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->date = $request->date;
        $sale->amount = $request->amount;
        $sale->customer_id = $request->customer_id;
        $sale->vehicle_id = $request->vehicle_id;
        $sale->save();

        return redirect()->route('sales.index')
            ->with('success', 'Venta actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        try {
            $result = $sale->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('sales.index')
                ->with('error', 'Error borrando la venta');
        }
        return redirect()->route('sales.index')
            ->with('success', 'Venta borrada correctamente.');
    }
}
