<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Concesionario</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css">
    <style>
        .content-body {
            font-family: "Arial", sans-serif;
        }

        .imagen-concesionario {
            height: 550px;
            background-color: rgba(0, 0, 0, 0.8);
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
            url('/media/concessionaires/concessionaire{{ $concessionaire->id }}.jpg');
            width: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            position: relative;
            z-index: 1;
        }

        .div-centro {
            width: 1100px;
            height: 900px;
            background-color: white;
            position: absolute;
            top: 820px;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }

        .titulo {
            position: absolute;
            top: 150px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            font-weight: bold;
            color: white;
            font-size: 44px;
        }

        .subtitulo {
            position: absolute;
            top: 220px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            color: white;
            font-size: 25px;
        }

        .telefono-h2 {
            position: absolute;
            top: 255px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            color: white;
            font-size: 20px;
        }

        .footer-class {
            position: absolute;
            top: 1270px;
            width: 100%;
        }

        .map {
            height: 440px;
            position: relative;
            width: 100%;
            border: 2px solid black;
        }

        .description {
            margin: 40px 70px;
            font-size: 16px;
        }

        .contenedor-de-columnas {
            display: flex;
            justify-content: space-between;
            margin: 40px 110px;
        }

        .columna-izquierda {
            flex: 1;
        }

        .columna-derecha {
            flex: 1;
        }

        p {
            font-size: 15px;
        }
    </style>
</head>

<body class="content-body">
    <img class="imagen-concesionario"></img>
    <h1 class="titulo">{{ $concessionaire->name }}</h1>
    <h2 class="subtitulo">{{ $concessionaire->address }}</h2>
    <h2 class="telefono-h2">{{ $concessionaire->phone_number }}</h2>
    <div class="div-centro">
        <p class="description">Para que disfrutes siempre de una experiencia excelente con tu vehículo, {{ $concessionaire->name }}, uno de los concesionarios oficiales de Hydra Motors, pone a tu disposición los mejores profesionales en Barcelona. Gracias a la experiencia del centro {{ $concessionaire->name }} en Barcelona disfrutarás siempre de la mejor relación calidad precio en todos sus vehículos, así como el servicio post-venta más fiable para vehículos Hydra Motors. No dejes de visitar tu centro {{ $concessionaire->name }}, en {{ $concessionaire->address }} y disfruta de la tranquilidad de un servicio a tu medida.</p>
        <div class="contenedor-de-columnas">
            <div class="columna-izquierda">
                <h3>Horario Comercial</h3>
                <p><strong>Ventas</strong></p>
                <p>Hoy 09:00 a 14:00 / 15:00 a 20:00</p>
                <p><strong>Taller</strong></p>
                <p>Hoy 8:00 a 13:00 / 15:00 a 19:00</p>
            </div>
            <div class="columna-derecha">
                <h3>Contacto</h3>
                <p><strong>Correo</strong></p>
                <p>{{ $concessionaire->email }}</p>
                <p><strong>Telefono</strong></p>
                <p>{{ $concessionaire->phone_number }}</p>
            </div>
        </div>
        <div class="map" id="map"></div>
    </div>
    <footer class="footer-class">
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibWlybzA1OCIsImEiOiJjbG9kNDVkZHAwNGtkMnFtZTljcnZjaDZ0In0.XpXVrnyKNcw367vQy4bgQA';

        var concessionaireId = <?php echo json_encode($concessionaire->id); ?>;

        switch (concessionaireId) {
            case 2:
                var locations = [{
                    name: 'Motorsol Import',
                    coordinates: [2.0468090385970794, 41.33544383183661]
                }, ];
                break;
            case 3:
                var locations = [{
                    name: 'Sarsa Valles',
                    coordinates: [2.038020338608017, 41.547991249256235]
                }, ];
                break;
            case 4:
                var locations = [{
                    name: 'Servisimó',
                    coordinates: [1.6254165809381844, 41.58887143480121]
                }, ];
                break;
            case 5:
                var locations = [{
                    name: 'Superwagen',
                    coordinates: [2.0624760116202747, 41.48016980496114]
                }, ];
                break;
            case 6:
                var locations = [{
                    name: 'Vilamòbil',
                    coordinates: [1.7361747250996866, 41.233057672194306]
                }, ];
                break;
            case 7:
                var locations = [{
                    name: 'Mogauto',
                    coordinates: [2.2074767809305578, 41.44056549892688]
                }, ];
                break;

            default:
                var locations = [{
                    name: 'Hydra Center BCN SUD',
                    coordinates: [2.1403913832109445, 41.33689605054748]
                }, ];
                break;
        }

        var barcelona = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: locations[0].coordinates,
            zoom: 11
        });

        // Agregar marcadores para las ubicaciones
        locations.forEach(function(location) {
            var marker = new mapboxgl.Marker()
                .setLngLat(location.coordinates)
                .setPopup(new mapboxgl.Popup().setHTML(location.name))
                .addTo(barcelona);
        });
    </script>
</body>
@endsection

</html>