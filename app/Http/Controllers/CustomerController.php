<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Concessionaire;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $concessionaires = Concessionaire::pluck('name','id');
        return view("customers.create", compact('concessionaires'));
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
        ]);
        
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customers.index')
            ->with('success','Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show',compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $concessionaires = Concessionaire::pluck('name','id');
        $customer = Customer::findOrFail($id);
        return view('customers.edit',compact('customer','concessionaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $request->validate([
            'name' => 'required|max:75',
            'phone_number' => 'required|regex:/^[69]\d{8}$/|max:11',
            'email' => 'required|email|max:40',
            'address' => 'required|max:75',
        ]);
        
        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->phone_number = $request->phone_number;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->save();

        return redirect()->route('customers.index')
            ->with('success','Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);

        try {
            $result = $customer->delete();
        }
        catch(\Illuminate\Database\QueryException $e) {
                return redirect()->route('customers.index')
                        ->with('error','Error borrando el cliente');
        }   
        return redirect()->route('customers.index')
                        ->with('success','Cliente borrado correctamente.'); 
    }

    public function editConcessionaires(Customer $customer) 
    {
        $arrayId = $customer->concessionaires->pluck('id');
        
        $concessionaires = Concessionaire::whereNotIn('id',$arrayId)->get();
        
        return view('customers.showConcessionaires',compact('customer','concessionaires'));
    }

    public function attachConcessionaires(Request $request, Customer $customer) 
    {
        $request->validate([
            'concessionaires' => 'exists:concessionaires,id',                       
        ]);

        $customer->concessionaires()->attach($request->concessionaires);
        
        return redirect()->route('customers.editConcessionaires',$customer->id)
                        ->with('success','Concesionarios asignados correctamente');
    }


    public function detachConcessionaires(Request $request, Customer $customer) 
    {
        $request->validate([
            'concessionaires' => 'exists:concessionaires,id',                       
        ]);

        if ($request->has('concessionaires'))
            $customer->concessionaires()->detach($request->concessionaires);
        
        return redirect()->route('customers.editConcessionaires',$customer->id)
                        ->with('success','Concessionarios extraidos correctamente');
    }
}
