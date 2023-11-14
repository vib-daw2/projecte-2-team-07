<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Concesionarios</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
    <style>
        .concessionaire-details {
            height: 420px;
            width: 1500px;
            display: flex;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            background-color: #f1f1f1;;
        }

        .left-column {
            flex: 1;
            padding-right: 20px;
        }

        .concessionaire-photo {
            width: 580px;
            height: 380px;
            border-radius: 5px;
        }

        .right-column {
            flex: 1.5;
        }

        h2 {
            color: #333;
            font-size: 24px;
            margin-top: 10px;
            padding-left: 20px;
            padding-bottom: 40px;
            font-weight: bold;
        }

        p {
            margin: 10px 0;
            padding-left: 20px;
        }

        .strong {
            font-weight: bold;
            color: #555;
        }

        .table-button {
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .concessionaire-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body class="content-body">
    @if(Auth::check() && Auth::user()->is_admin)
    <div class="edit-tables">
        <div class="table-button">
            <a href="{{ route('concessionaires.create') }}" class="btn btn-primary">Crear Concesionario</a>
        </div>
        <h1>Tabla de Concesionarios</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Dirección</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($concessionaires as $concessionaire)
                <tr>
                    <td>{{ $concessionaire->id }}</td>
                    <td>{{ $concessionaire->name }}</td>
                    <td>{{ $concessionaire->phone_number }}</td>
                    <td>{{ $concessionaire->email }}</td>
                    <td>{{ $concessionaire->address }}</td>

                    <td>
                        <a href="{{ route('concessionaires.edit',$concessionaire->id) }}">Editar</a>
                        <a href="{{ route('concessionaires.show',$concessionaire->id) }}">Mostrar</a>
                        <a href="{{ route('concessionaires.destroy',$concessionaire->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
    <div class="concessionaire-container">
        @foreach ($concessionaires as $concessionaire)
        <div class="concessionaire-details">
            <div class="left-column">
                @php
                $photoName = "concessionaire" . $loop->iteration . ".jpg";
                @endphp
                <img class="concessionaire-photo" src="/media/concessionaires/{{ $photoName }}" alt="{{ $concessionaire->name }}">
            </div>
            <div class="right-column">
                <h2>{{ $concessionaire->name }}</h2>
                <p><strong>Teléfono:</strong> {{ $concessionaire->phone_number }}</p>
                <p><strong>Correo Electrónico:</strong> {{ $concessionaire->email }}</p>
                <p><strong>Dirección:</strong> {{ $concessionaire->address }}</p>
                <div style="margin-top: 20px;" class="table-button">
                    <a href="{{ route('concessionaires.show',$concessionaire->id) }}" class="btn btn-primary">Saber más</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <footer>
        <div class="footer-content">
            <div class="policy">
                <h3>Nutzungsbedingungen</h3>
                <p>Unsere Nutzungsbedingungen sind verbindlich. Wenn Sie diese Website nutzen, akzeptieren Sie automatisch unsere strengen Nutzungsrichtlinien.</p>
            </div>
            <div class="sponsors">
                <h3>Unsere Sponsoren</h3>
                <ul>
                    <li><a href="#">Fortschrittliche Technologie GmbH</a></li>
                    <li><a href="#">Kreatives Design AG</a></li>
                    <li><a href="#">Innovationszentrum Berlin</a></li>
                    <li><a href="#">Deutsche Wundergruppe</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 Tu Sitio Web - Todos los derechos reservados.</p>
        </div>
    </footer>
    @endif
</body>
@endsection

</html>