<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Crear Usuario</title>
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

    <form class="create-form" method="POST" action="{{ route('users.update',$user->id) }}">
        <h1>Editar Usuario</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>

        <label for="permissions">Permisos:</label>
        <select name="permissions" id="permissions" required>
            <option value="1" @if($user->permissions == '1') selected @endif>Cliente</option>
            <option value="2" @if($user->permissions == '2') selected @endif>Empleado</option>
            <option value="3" @if($user->permissions == '3') selected @endif>Administrador</option>
        </select>

        <div id="employeeInformation" @if ($user->permissions ==2)style="display: block; @else style="display: none; @endif">
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" @if(isset($employee->dni)) value="{{ $employee->dni }}" @else value="00000000A" @endif required>

            <label for="charge">Cargo:</label>
            <select name="charge" id="charge" required>
                <option value="Ayudante" @if(isset($employee->charge) == 'Ayudante') selected @endif>Ayudante</option>
                <option value="Director" @if(isset($employee->charge) == 'Director') selected @endif>Director</option>
                <option value="Gerente" @if(isset($employee->charge) == 'Gerente') selected @endif>Gerente</option>
                <option value="Asesor" @if(isset($employee->charge) == 'Asesor') selected @endif>Asesor</option>
                <option value="Técnico" @if(isset($employee->charge) == 'Técnico') selected @endif>Técnico</option>
                <option value="Operador" @if(isset($employee->charge) == 'Operador') selected @endif>Operador</option>
            </select>

            <label for="department">Departamento:</label>
            <select name="department" id="department" required>
                <option value="Asistencia técnica" @if(isset($employee->department) == 'Asistencia técnica') selected @endif>Asistencia técnica</option>
                <option value="Ventas" @if(isset($employee->department) == 'Ventas') selected @endif>Ventas</option>
                <option value="Finanzas" @if(isset($employee->department) == 'Finanzas') selected @endif>Finanzas</option>
                <option value="Marketing" @if(isset($employee->department) == 'Marketing') selected @endif>Marketing</option>
                <option value="Recursos Humanos" @if(isset($employee->department) == 'Recursos Humanos') selected @endif>Recursos Humanos</option>
                <option value="Atención al Cliente" @if(isset($employee->department) == 'Atención al Cliente') selected @endif>Atención al Cliente</option>
            </select>

            <label for="concessionaire_id">ID del Concesionario:</label>
            <select name="concessionaire_id" id="concessionaire_id">
                @foreach ($concessionaires as $id => $name)
                <option value="{{ $id }}" @if ($id==isset($employee->concessionaire_id)) selected @endif>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <input type="submit" value="Guardar" class="btn btn-secondary">
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
    <script>
            const permissionsSelect = document.getElementById('permissions');
            const employeeInformation = document.getElementById('employeeInformation');

            permissionsSelect.addEventListener('change', () => {
                if (permissionsSelect.value == '2') {
                    employeeInformation.style.display = 'block';
                } else {
                    employeeInformation.style.display = 'none';
                }
            });
        </script>
</body>
@endsection

</html>