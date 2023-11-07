<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Crear Empleado</title>
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

    <form class="create-form" method="POST" action="{{ route('employees.update',$employee->id) }}">
        <h1>Editar Empleado</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $employee->name }}" required>

        <label for="phone_number">Teléfono:</label>
        <input type="tel" id="phone_number" name="phone_number" value="{{ $employee->phone_number }}" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $employee->email }}" required>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" value="{{ $employee->address }}" required>

        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" value="{{ $employee->dni }}" required>

        <label for="charge">Cargo:</label>
        <select name="charge" id="charge" required>
            <option value="Ayudante" @if($employee->charge == 'Ayudante') selected @endif>Ayudante</option>
            <option value="Director" @if($employee->charge == 'Director') selected @endif>Director</option>
            <option value="Gerente" @if($employee->charge == 'Gerente') selected @endif>Gerente</option>
            <option value="Asesor" @if($employee->charge == 'Asesor') selected @endif>Asesor</option>
            <option value="Técnico" @if($employee->charge == 'Técnico') selected @endif>Técnico</option>
            <option value="Operador" @if($employee->charge == 'Operador') selected @endif>Operador</option>
        </select>

        <label for="department">Departamento:</label>
        <select name="department" id="department" required>
            <option value="Asistencia técnica" @if($employee->department == 'Asistencia técnica') selected @endif>Asistencia técnica</option>
            <option value="Ventas" @if($employee->department == 'Ventas') selected @endif>Ventas</option>
            <option value="Finanzas" @if($employee->department == 'Finanzas') selected @endif>Finanzas</option>
            <option value="Marketing" @if($employee->department == 'Marketing') selected @endif>Marketing</option>
            <option value="Recursos Humanos" @if($employee->department == 'Recursos Humanos') selected @endif>Recursos Humanos</option>
            <option value="Atención al Cliente" @if($employee->department == 'Atención al Cliente') selected @endif>Atención al Cliente</option>
        </select>

        <label for="concessionaire_id">ID del Concesionario:</label>
        <select name="concessionaire_id" id="concessionaire_id">
            @foreach ($concessionaires as $id => $name)
            <option value="{{ $id }}" @if ($id==$employee->concessionaire_id) selected @endif>{{ $name }}</option>
            @endforeach
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