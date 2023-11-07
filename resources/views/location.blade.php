<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <title>Localizaciones</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css">
</head>

<body class="content-body">
    <div id="map" style="height: 650px;"></div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibWlybzA1OCIsImEiOiJjbG9kNDVkZHAwNGtkMnFtZTljcnZjaDZ0In0.XpXVrnyKNcw367vQy4bgQA'; 

        var barcelona = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11', 
            center: [2.1734, 41.3851], 
            zoom: 9
        });

        var locations = [{
                name: 'Hydra Center BCN SUD',
                coordinates: [2.1403913832109445, 41.33689605054748]
            },
            {
                name: 'Motorsol Import',
                coordinates: [2.0468090385970794, 41.33544383183661]
            },
            {
                name: 'Sarsa Valles',
                coordinates: [2.038020338608017, 41.547991249256235]
            },
            {
                name: 'Servisimó',
                coordinates: [1.6254165809381844, 41.58887143480121]
            },
            {
                name: 'Superwagen',
                coordinates: [2.0624760116202747, 41.48016980496114]
            },
            {
                name: 'Vilamòbil',
                coordinates: [1.7361747250996866, 41.233057672194306]
            },
            {
                name: 'Mogauto',
                coordinates: [2.2074767809305578, 41.44056549892688]
            }
        ];

        locations.forEach(function(location) {
            var marker = new mapboxgl.Marker()
                .setLngLat(location.coordinates)
                .setPopup(new mapboxgl.Popup().setHTML(location.name))
                .addTo(barcelona);
        });
    </script>
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