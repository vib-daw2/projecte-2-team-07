<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Clientes</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="content-body">
    <div class="edit-tables">
        <div class="table-button">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Crear Cliente</a>
        </div>
        <h1>Tabla de Clientes</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Dirección</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone_number }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->address }}</td>

                    <td>
                        <a href="{{ route('customers.edit',$customer->id) }}">Editar</a>
                        <a href="{{ route('customers.show',$customer->id) }}">Mostrar</a>
                        <a href="{{ route('customers.destroy',$customer->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>