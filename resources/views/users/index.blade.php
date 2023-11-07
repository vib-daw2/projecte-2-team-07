<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Tabla de Usuarios</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">
    <div class="edit-tables">
        <h1>Tabla de Usuarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Permisos</th>
                    <th>Creado en</th>
                    <th>Actualizado en</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <?php
                        switch ($user->permissions) {
                            case '1':
                                echo "Cliente";
                                break;
                            case '2':
                                echo "Empleado";
                                break;
                            case '3':
                                echo "Administrador";
                                break;
                            default:
                                echo "Cliente";
                                break;
                        }
                        ?>
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>{{ $user->updated_at }}</td>

                    <td>
                        <a href="{{ route('users.edit',$user->id) }}">Editar</a>
                        <a href="{{ route('users.destroy',$user->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
@endsection

</html>