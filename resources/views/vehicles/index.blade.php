<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Vehiculos disponibles</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .vehicle-item:hover .details-card {
            color: red;
        }

        .vehicle-card {
            background-color: white;
            margin: 0 0.2vw;
            height: 22vw;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 2.2vw;
        }

        .vehicle-card p.title-paragraph {
            text-align: left;
            font-size: 1.7vw;
            padding-top: 1.5vw;
            padding-left: 1.5vw;
            white-space: nowrap;
            margin-bottom: 0 !important;
        }

        .details-card {
            background-color: black;
            color: white;
            margin: 0 0.2vw;
            padding: 0.4vw;
        }

        .container-vehicles h2.model-title {
            margin-bottom: 1vw;
            text-align: center;
            font-size: 3vw;
        }

        .container-vehicles h2.model-title:not(:first-child) {
            margin-top: 1.8vw;
        }

        .details-card p.detail-paragraph {
            text-align: left;
            margin-bottom: 0;
            padding-left: 1vw;
            font-size: 1vw;
        }

        .vehicle-card img.vehicle-image {
            margin-top: auto;
            padding: 0.4vw;
        }

        .container-vehicles {
            background-color: #eaeaeae3;
            padding: 2vw 5%;
        }

        .vehicle-item {
            flex-basis: 30%;
            text-align: center;
            overflow: hidden;
            width: 21vw;
            border-radius: 2.2vw;
        }

        .vehicle-item img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .vehicle-item a {
            text-decoration: none;
            color: #333;
        }

        .vehicle-item p {
            font-size: 1vw;
            text-align: center;
        }
    </style>
</head>

<body class="content-body">
    @if(Auth::check() && Auth::user()->is_employee)
    <div class="edit-tables">
        <div class="table-button">
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Crear Vehiculo</a>
        </div>
        <h1>Tabla de Vehiculos</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Combustible</th>
                    <th>Precio</th>
                    <th>Motor</th>
                    <th>Año de producción</th>
                    <th>Nombre foto</th>
                    <th>ID Concesionario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->id }}</td>
                    <td>{{ $vehicle->name }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->fuel }}</td>
                    <td>{{ $vehicle->price }}</td>
                    <td>{{ $vehicle->motor }}</td>
                    <td>{{ $vehicle->production_year }}</td>
                    <td>{{ $vehicle->picture }}</td>
                    <td>{{ $vehicle->concessionaire_id }}</td>
                    <td>
                        <a href="{{ route('vehicles.edit',$vehicle->id) }}">Editar</a>
                        <a href="{{ route('vehicles.show',$vehicle->id) }}">Mostrar</a>
                        <a href="{{ route('vehicles.destroy',$vehicle->id) }}">Borrar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @else
    <div class="container-vehicles">
        @php
        $alreadyDisplayedNames = [];
        $groupedVehicles = [];

        foreach ($vehicles as $vehicle) {
        $model = $vehicle->model;

        if (!isset($groupedVehicles[$model])) {
        $groupedVehicles[$model] = [];
        }

        $groupedVehicles[$model][] = $vehicle;
        }
        @endphp

        @foreach ($groupedVehicles as $model => $modelVehicles)
        <h2 class="model-title">{{ $model }}</h2>
        <div class="catalog-container">
            @foreach($modelVehicles as $vehicle)
            @if (!in_array($vehicle->picture, $alreadyDisplayedNames))
            <div class="vehicle-item">
                <a href="{{ route('vehicles.show',$vehicle->id) }}">
                    <div class="vehicle-card">
                        <p class="title-paragraph">{{ str_replace('Hydra', '', $vehicle->name) }}</p>
                        <img class="vehicle-image" src="/media/vehicles/{{ $vehicle->picture }}" alt="Auto 1">
                    </div>
                    <div class="details-card">
                        <p class="detail-paragraph">{{ $vehicle->fuel }}</p>
                        <p class="detail-paragraph">Desde {{ number_format($vehicle->price, 0, ',', '.') }}€</p>
                    </div>
                </a>
                @php
                $alreadyDisplayedNames[] = $vehicle->picture;
                @endphp
            </div>
            @endif
            @endforeach
        </div> <!-- Cierra el div para cada modelo -->
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