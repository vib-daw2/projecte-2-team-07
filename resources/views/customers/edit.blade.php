<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')
<head>
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="content-body">
    <div> 
        @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>        
            @endif
    </div>

    <form class="create-form" method="POST" action="{{ route('customers.update',$customer->id) }}">
        <h1>Editar Cliente</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $customer->name }}" required>

        <label for="phone_number">Teléfono:</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $customer->email }}" required>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" value="{{ $customer->address }}" required>

        <input type="submit" value="Guardar" class="btn btn-secondary">
        <div class="botones">
            <a href="{{ route('customers.editConcessionaires', ['customer' => $customer->id]) }}" class="btn btn-primary">Editar Concesionarios asignados</a>
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