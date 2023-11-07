<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Clientes</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">
    <div class="edit-tables">
        <h1>Ficha de cliente</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Dirección</th>
                    <th>Concesionarios</th>
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone_number }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <ul>
                            @foreach($customer->concessionaires as $concessionaire)
                            <li> {{ $concessionaire->name }} </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $customer->created_at }}</td>
                    <td>{{ $customer->updated_at }}</td>
                    <td>
                        <a href="{{ route('customers.edit',$customer->id) }}">Editar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>