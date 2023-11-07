<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Crear Empleado</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">

    <form class="create-form" method="POST" action="{{ route('employees.store') }}">
        <h1>Crear Empleado</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>

        <label for="phone_number">Teléfono:</label>
        <input type="tel" id="phone_number" name="phone_number" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" required>

        <label for="charge">Cargo:</label>
        <select name="charge" id="charge">
            <option value="Ayudante">Ayudante</option>
            <option value="Director">Director</option>
            <option value="Gerente">Gerente</option>
            <option value="Asesor">Asesor</option>
            <option value="Técnico">Técnico</option>
            <option value="Operador">Operador</option>
        </select>

        <label for="department">Departamento:</label>
        <select name="department" id="department">
            <option value="Asistencia técnica">Asistencia técnica</option>
            <option value="Ventas">Ventas</option>
            <option value="Finanzas">Finanzas</option>
            <option value="Marketing">Marketing</option>
            <option value="Recursos Humanos">Recursos Humanos</option>
            <option value="Atención al Cliente">Atención al Cliente</option>
        </select>

        <label for="concessionaire_id">ID del Concesionario:</label>
        <select name="concessionaire_id" id="concessionaire_id">
            @foreach ($concessionaires as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>

        <input class="btn btn-primary" type="submit" value="Crear Empleado">
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