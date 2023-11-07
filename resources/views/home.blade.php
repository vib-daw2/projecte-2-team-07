<!DOCTYPE html>
<html>
@extends('layouts.app')
@section('content')

<head>
    <meta charset="utf-8">
    <title>Hydra-Motor</title>
    <link rel="stylesheet" href="/css/estilo1.css">
    <link rel="icon" href="/media/photos/10.ico" type="image/x-icon">
</head>

<body class="fade-in">

    <img src="../media/photos/9.jpg" alt="Imagen de Portada" class="cover-image">
    <nav class="thin-navbar">
        <ul>
            <li><a href="{{route('vehicles.index')}}">Tienda</a></li>
            <li><a href="{{route('location')}}">Localiza tu concesionario</a></li>
            <li><a href="sc.php">Solicitud de contacto</a></li>
            <li><a href="calendario.php">Calendario</a></li>
            <li><a href="admin.php">Administradores</a></li>
        </ul>
    </nav>
    <br>
    <br>
    <br>
    <div class="catalog-container">
        <div class="catalog-item">
            <img src="../media/photos/8.png" alt="Imagen 1">
        </div>
        <div class="catalog-item">
            <img src="../media/photos/4.png" alt="Imagen 2">
        </div>
        <div class="catalog-item">
            <img src="../media/photos/tw.png" alt="Imagen 3">
        </div>
        <div class="catalog-item">
            <img src="../media/photos/6.png" alt="Imagen 4">
        </div>
    </div>
    <br>
    <div class="black-box">
        <div class="content">
            <h2>Quiénes somos</h2>
            <p>Somos Hydra-Motor, una empresa alemana veterana en la industria automotriz. Fundada hace más de medio siglo, nuestra pasión por la innovación y la excelencia nos ha llevado a ser líderes en la fabricación de vehículos de alta calidad. Nuestro compromiso con la ingeniería de vanguardia y la satisfacción del cliente nos ha impulsado a lo largo de los años. </p>

            <p>Desde nuestros inicios, hemos estado dedicados a desarrollar soluciones de movilidad sostenible y eficiente. Nuestros vehículos son reconocidos por su rendimiento, seguridad y diseño elegante. Trabajamos incansablemente para mantener y superar los estándares más altos de la industria, brindando a nuestros clientes una experiencia única al volante.</p>

            <p>Nuestra visión es impulsar un futuro más limpio y conectado a través de la innovación automotriz. Continuamos invirtiendo en investigación y desarrollo para ofrecer vehículos de última generación que sean amigables con el medio ambiente y estén equipados con tecnología de vanguardia.</p>
        </div>
    </div>

    <div class="news-container">
        <div class="news-item">
            <img src="../media/photos/12.jpg" alt="Noticia 1" class="news-image">
            <h2 class="news-title">Hydra-Electric</h2>
            <p class="news-description">Innovación en energías renovables: Hydra Motor revela su primer prototipo de coche eléctrico.</p>
            <a href="new1.php" class="news-link">Leer más</a>
        </div>
        <div class="news-item">
            <img src="../media/photos/13.jpg" alt="Noticia 2" class="news-image">
            <h2 class="news-title">Seguridad</h2>
            <p class="news-description">Innovación en seguridad: los vehículos de Hydra Motor obtienen altas calificaciones en pruebas de choque.</p>
            <a href="new2.php" class="news-link">Leer más</a>
        </div>
        <div class="news-item">
            <img src="../media/photos/14.jpg" alt="Noticia 3" class="news-image">
            <h2 class="news-title">500 empleos nuevos</h2>
            <p class="news-description">Nueva planta de producción de Hydra Motor abrirá 500 empleos locales.</p>
            <a href="new3.php" class="news-link">Leer más</a>
        </div>
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