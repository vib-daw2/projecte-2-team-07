<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Ventas</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">
    <div class="edit-tables">
        <h1>Tabla de Ventas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha de la compra</th>
                    <th>Importe</th>
                    <th>Nombre Cliente</th>
                    <th>Vehiculo</th>
                    <th>Concesionario</th>
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->date }}</td>
                    <td>{{ $sale->amount }}</td>
                    <td>{{ $sale->customer->name }}</td>
                    <td>{{ $sale->vehicle->name }}</td>
                    <td>{{ $sale->concessionaire->name }}</td>
                    <td>{{ $sale->created_at }}</td>
                    <td>{{ $sale->updated_at }}</td>

                    <td>
                        <a href="{{ route('sales.destroy',$sale->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</body>
@endsection

</html>