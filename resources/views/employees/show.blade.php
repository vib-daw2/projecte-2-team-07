<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Empleados</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">
    <div class="edit-tables">
        <h1>Ficha de trabajador</h1>
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
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
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
                    <td>{{ $employee->created_at }}</td>
                    <td>{{ $employee->updated_at }}</td>
                    <td>
                        <a href="{{ route('employees.edit',$employee->id) }}">Editar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>