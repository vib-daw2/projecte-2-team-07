<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Vehiculo</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .vehicle-details {
            display: flex;
            padding: 20px;
            margin: 20px;
            background-color: #f9f9f9;
        }

        .left-column {
            flex: 1.5;
            padding-right: 20px;
        }

        .vehicle-photo {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .right-column {
            flex: 1.5;
        }

        h2 {
            font-weight: bold;
            color: #333;
            font-size: 24px;
            margin-top: 10px;
            padding-left: 20px;
            padding-bottom: 20px;
        }

        p {
            margin: 5px 0;
            padding-left: 20px;
        }

        .strong {
            font-weight: bold;
            color: #555;
        }

        .vehicle-dates {
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        select {
            margin-left: 10px;
        }
    </style>
</head>

<body class="content-body">
    <form class="vehicle-details" method="POST" action="{{ route('sales.store') }}">
        @csrf
        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        <input type="hidden" name="vehicle_price" value="{{ $vehicle->price }}">
        <input type="hidden" name="vehicle_name" value="{{ $vehicle->name }}">
        <div class="left-column">
            <img class="vehicle-photo" src="/media/vehicles/{{ $vehicle->picture }}" alt="{{ $vehicle->name }}">
        </div>
        <div class="right-column">
            <h2>{{ $vehicle->name }}</h2>
            <p><strong>Modelo:</strong> {{ $vehicle->model }}</p>
            <p><strong>Combustible:</strong> {{ $vehicle->fuel }}</p>
            <p><strong>Precio:</strong> {{ number_format($vehicle->price, 0, '.', '.') }}€</p>
            <p><strong>Motor:</strong> {{ $vehicle->motor }}</p>
            <p><strong>Fecha de Producción:</strong> {{ $vehicle->production_year }}</p>
            <div class="vehicle-dates">
                <p><strong>Concessionarios disponibles:</strong></p>
                <select name="concessionaire_id" id="concessionaire_id">
                    @foreach ($concessionaires as $id => $concessionaire)
                    <option value="{{ $concessionaire->id }}">
                        {{ $concessionaire->name }} ({{ $concessionaire['address'] }})
                    </option>
                    @endforeach
                </select>
            </div>
            @if(Auth::check() && Auth::user()->is_employee)
            <p><strong>Clientes disponibles:</strong></p>
            <select style="margin-bottom: 70px;" name="customer_id" id="customer_id">
                @foreach ($customers as $id => $name)
                <option value="{{ $id }}">
                    {{ $name }}
                </option>
                @endforeach
            </select>
            <div class="create-button" type="submit">
                <input class="btn btn-primary" type="submit" value="Crear Compra">
            </div>
            @else
            <div class="create-button" type="submit">
                <input class="btn btn-primary" type="submit" value="Comprar">
            </div>
            @endif
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
</body>
@endsection

</html>