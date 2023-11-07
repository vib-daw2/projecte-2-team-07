<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Editar Concesionario</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">
    
    <form class="create-form" method="POST" action="{{ route('concessionaires.update',$concessionaire->id) }}">
        <h1>Editar Concesionario</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $concessionaire->name }}" required>

        <label for="phone_number">Teléfono:</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ $concessionaire->phone_number }}" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $concessionaire->email }}" required>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" value="{{ $concessionaire->address }}" required>

        <input type="submit" value="Guardar" class="btn btn-secondary">
        <div class="botones">
            <a href="{{ route('concessionaires.editCustomers', ['concessionaire' => $concessionaire->id]) }}" class="btn btn-primary">Editar Clientes</a>
            <a href="{{ route('concessionaires.editVehicles', ['concessionaire' => $concessionaire->id]) }}" class="btn btn-primary">Editar Vehiculos</a>
            <a href="{{ route('concessionaires.editEmployees', ['concessionaire' => $concessionaire->id]) }}" class="btn btn-primary">Editar Empleados</a>
        </div>
    </form>

    <div>
        @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
</body>
@endsection

</html>