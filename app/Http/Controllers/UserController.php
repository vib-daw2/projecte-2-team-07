<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Concessionaire;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $concessionaires = Concessionaire::pluck('name', 'id');
        $user = User::findOrFail($id);
        if ($user->permissions == 2) {
            $employee = Employee::where('user_id', $user->id)->firstOrFail();
            return view('users.edit', compact('user', 'concessionaires', 'employee'));
        }
        return view('users.edit', compact('user', 'concessionaires'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:75',
            'email' => 'required|max:40',
            'permissions' => 'required',
        ]);

        $user = User::findOrFail($id);

        if ($user->permissions != 3) {
            if ($request->permissions == 2) {
                try {
                    $customer = Customer::where('user_id', $user->id)->firstOrFail();

                    $request->validate([
                        'dni' => 'required|regex:/^[XYZ]?\d{7,8}[A-Z]$/|max:10',
                        'charge' => 'required',
                        'department' => 'required',
                        'concessionaire_id' => 'required',
                    ]);

                    $employee = new Employee;
                    $employee->name = $customer->name;
                    $employee->phone_number = $customer->phone_number;
                    $employee->email = $customer->email;
                    $employee->address = $customer->address;
                    $employee->dni = $request->dni;
                    $employee->charge = $request->charge;
                    $employee->department = $request->department;
                    $employee->concessionaire_id = $request->concessionaire_id;
                    $employee->user_id = $user->id;
                    $employee->save();

                    $customer->delete();
                } catch (\Throwable $th) {
                }
            }

            if ($request->permissions == 1) {
                try {
                    $employee = Employee::where('user_id', $user->id)->firstOrFail();

                    $request->validate([
                        'dni' => 'required|regex:/^[XYZ]?\d{7,8}[A-Z]$/|max:10',
                        'charge' => 'required',
                        'department' => 'required',
                        'concessionaire_id' => 'required',
                    ]);

                    $customer = new Customer;
                    $customer->name = $employee->name;
                    $customer->phone_number = $employee->phone_number;
                    $customer->email = $employee->email;
                    $customer->address = $employee->address;
                    $customer->user_id = $user->id;
                    $customer->save();

                    $employee->delete();
                } catch (\Throwable $th) {
                }
            }

            if ($request->permissions == 3) {
                try {
                    $employee = Employee::where('user_id', $user->id)->firstOrFail();
                    $employee->delete();
                } catch (\Throwable $th) {
                }
                try {
                    $customer = Customer::where('user_id', $user->id)->firstOrFail();
                    $customer->delete();
                } catch (\Throwable $th) {
                }
            }
            $user->permissions = $request->permissions;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        try {
            if ($user->permissions == 1) {
                $customer = Customer::where('user_id', $user->id)->firstOrFail();
                $customer->delete();
            }
            if ($user->permissions == 2) {
                $employee = Employee::where('user_id', $user->id)->firstOrFail();
                $employee->delete();
            }
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('users.index')
                ->with('error', 'Error borrando el usuario');
        }
        return redirect()->route('users.index')
            ->with('success', 'Usuario borrado correctamente.');
    }
}
