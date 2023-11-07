<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Editar Vehiculo</title>
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

    <form class="create-form" method="POST" action="{{ route('vehicles.update',$vehicle->id) }}">
        <h1>Editar Vehiculo</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $vehicle->name }}" required>

        <label for="model">Modelo:</label>
        <select name="model" id="model" required>
            <option value="Crossover" @if($vehicle->model == 'Crossover') selected @endif>Crossover</option>
            <option value="Sedan" @if($vehicle->model == 'Sedan') selected @endif>Sedan</option>
            <option value="Sport" @if($vehicle->model == 'Sport') selected @endif>Sport</option>
            <option value="Coupe" @if($vehicle->model == 'Coupe') selected @endif>Coupe</option>
        </select>

        <label for="fuel">Combustible:</label>
        <select name="fuel" id="fuel" required>
            <option value="Gasolina" @if($vehicle->fuel == 'Gasolina') selected @endif>Gasolina</option>
            <option value="Diésel" @if($vehicle->fuel == 'Diésel') selected @endif>Diésel</option>
            <option value="Hibrido" @if($vehicle->fuel == 'Hibrido') selected @endif>Hibrido</option>
            <option value="Eléctrico" @if($vehicle->fuel == 'Eléctrico') selected @endif>Eléctrico</option>
        </select>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" value="{{ $vehicle->price }}" required>

        <label for="motor">Motor:</label>
        <input type="text" id="motor" name="motor" value="{{ $vehicle->motor }}" required>

        <label for="production_year">Año de producción:</label>
        <input type="date" id="production_year" name="production_year" value="{{ $vehicle->production_year }}" required>

        <label for="photo">Nombre foto:</label>
        <input type="text" id="photo" name="photo" value="{{ $vehicle->photo }}" required>

        <label for="concessionaire_id">ID del Concesionario:</label>
        <select name="concessionaire_id" id="concessionaire_id">
            @foreach ($concessionaires as $id => $name)
            <option value="{{ $id }}" @if ($id==$vehicle->concessionaire_id) selected @endif>{{ $name }}</option>
            @endforeach
            <option value="">Sin Concesionario</option>
        </select>

        <input class="btn btn-secondary" type="submit" value="Guardar">
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