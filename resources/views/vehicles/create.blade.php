<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Crear Vehiculo</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">

    <form class="create-form" method="POST" action="{{ route('vehicles.store') }}">
        <h1>Crear Vehiculo</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>

        <label for="model">Modelo:</label>
        <select name="model" id="model">
            <option value="Crossover">Crossover</option>
            <option value="Sedan">Sedan</option>
            <option value="Sport">Sport</option>
            <option value="Coupe">Coupe</option>
        </select>

        <label for="fuel">Combustible:</label>
        <select name="fuel" id="fuel">
            <option value="Gasolina">Gasolina</option>
            <option value="Diésel">Diésel</option>
            <option value="Hibrido">Hibrido</option>
            <option value="Eléctrico">Eléctrico</option>
        </select>

        <label for="price">Precio:</label>
        <input type="number" id="price" name="price" required>

        <label for="motor">Motor:</label>
        <input type="text" id="motor" name="motor" required>

        <label for="production_year">Año de producción:</label>
        <input type="date" id="production_year" name="production_year" required>

        <label for="photo">Nombre foto:</label>
        <input type="text" id="photo" name="photo" required>

        <label for="concessionaire_id">ID del Concesionario:</label>
        <select name="concessionaire_id" id="concessionaire_id">
            @foreach ($concessionaires as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
            <option value="">Sin Concesionario</option>
        </select>

        <input class="btn btn-primary" type="submit" value="Crear Vehiculo">
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