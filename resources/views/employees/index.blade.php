<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Empleados</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
    <div class="edit-tables">
        <div class="table-button">
            <a href="{{ route('employees.create') }}" class="btn btn-primary">Crear Empleado</a>
        </div>
        <h1>Tabla de Empleados</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Dirección</th>
                    <th>DNI</th>
                    <th>Cargo</th>
                    <th>Departamento</th>
                    <th>ID del Concesionario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->phone_number }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->address }}</td>
                    <td>{{ $employee->dni }}</td>
                    <td>{{ $employee->charge }}</td>
                    <td>{{ $employee->department }}</td>
                    <td>{{ $employee->concessionaire_id }}</td>

                    <td>
                        <a href="{{ route('employees.edit',$employee->id) }}">Editar</a>
                        <a href="{{ route('employees.show',$employee->id) }}">Mostrar</a>
                        <a href="{{ route('employees.destroy',$employee->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>