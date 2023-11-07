<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Crear Cliente</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="content-body">

    <form class="create-form" method="POST" action="{{ route('customers.store') }}">
        <h1>Crear Cliente</h1>
        @csrf
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>

        <label for="phone_number">Teléfono:</label>
        <input type="tel" id="phone_number" name="phone_number" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="address">Dirección:</label>
        <input type="text" id="address" name="address" required>

        <input class="btn btn-primary" type="submit" value="Crear Cliente">
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