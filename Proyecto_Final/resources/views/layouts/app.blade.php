<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js" integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ==" crossorigin=""></script>

    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" /> -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <!-- <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script> -->
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        #mimapa {
            height: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- Debe ser un logo pequeño -->
                    <img src="/storage/imagenes/iconos/logo.jpg" alt="logo" class="img-fluid" style="width: 50px; height: 50px; transform: scale(1.5);">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('mensajes.login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('mensajes.register') }}</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="abrir('ajustes')">{{ __('mensajes.settings') }}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="abrir('miUbicacion')">{{ __('mensajes.ubication') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="abrir('rutas')">{{ __('mensajes.routes') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="abrir('misContactos')">{{ __('mensajes.myContacts') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" @click="abrir('contacto')">{{ __('mensajes.addContact') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="#" @click="abrir('ajustes')">{{ __('mensajes.settings') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('mensajes.logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <div id="mimapa"></div>
    <script>
        var map = L.map('mimapa').setView([-34.6037, -58.3816], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        let route = '13.342642380218225,-88.39153289794922;13.340972096562783,-88.42002868652345;13.344306127847219,-88.43616485595705;13.355663672110932,-88.42964172363281;13.358168940817684,-88.43539237976076;13.359171041017222,-88.44088554382326;13.359922613435444,-88.44697952270509;13.357500871705762,-88.45152854919435;13.352239762819204,-88.45693588256837;13.345057746547587,-88.46526145935059;13.341967743600684,-88.46869468688965';
        let route2 = '13.34021394056204,-88.47925186157228;13.341869223008556,-88.42496395111085;13.34278787703673,-88.43028545379639;13.343511118890152,-88.43444824218751;13.347707640518639,-88.436336517334;13.349189976500867,-88.43571424484254;13.351027225370173,-88.43358993530275;13.353198501462149,-88.43236684799194'
        let recorrido = route.split(';');
        let recorrido2 = route2.split(';');
        // recorrido = recorrido.map(coordenada => {
        //     coordenada = coordenada.split(',');
        //     return [parseFloat(coordenada[0]), parseFloat(coordenada[1])];
        // });
        let rutazz = [];
        let rutazz2 = [];
        for (let i = 0; i < recorrido.length; i++) {
            let coordenada = recorrido[i].split(',');
            L.latLng(parseFloat(coordenada[0]), parseFloat(coordenada[1]));
            rutazz.push(L.latLng(parseFloat(coordenada[0]), parseFloat(coordenada[1])));
        }
        for (let i = 0; i < recorrido2.length; i++) {
            let coordenada = recorrido2[i].split(',');
            L.latLng(parseFloat(coordenada[0]), parseFloat(coordenada[1]));
            rutazz2.push(L.latLng(parseFloat(coordenada[0]), parseFloat(coordenada[1])));
        }
        console.log(rutazz);
        window.ruteishon = rutazz;

        var markStart = L.marker(rutazz[0]).addTo(map);
        markStart.bindPopup("Ruta 1 Inicio");
        var markEnd = L.marker(rutazz[rutazz.length - 1]).addTo(map);
        markEnd.bindPopup("Ruta 1 Fin");
        var ruta = L.Routing.control({
            createMarker: function() { return null; },
            waypoints: rutazz,
            draggable: false,
            routeWhileDragging: false,
            showAlternatives: false,
        }).addTo(map);

        var markStart2 = L.marker(rutazz2[0]).addTo(map);
        markStart2.bindPopup("Ruta 2 Inicio");
        var markEnd2 = L.marker(rutazz2[rutazz2.length - 1]).addTo(map);
        markEnd2.bindPopup("Ruta 2 Fin");
        var ruta2 = L.Routing.control({
            createMarker: function() { return null; },
            waypoints: rutazz2,
            draggable: false,
            routeWhileDragging: false,
            showAlternatives: false,
        }).addTo(map);
    </script>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.5.1/socket.io.min.js"></script>
</body>
</html>
