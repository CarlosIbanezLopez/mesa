<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        /* General */
        body {
            background-color: #ffffff;
            color: #000000;
        }

        /* Modo oscuro */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        /* Sidebar */
        body.dark-mode .sidebar {
            background-color: #1e1e1e;
        }

        /* Navbar */
        body.dark-mode .navbar {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        body.dark-mode .navbar .nav-link {
            color: #b3b3b3;
        }

        /* Cards */
        body.dark-mode .card {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        /* Tablas */
        body.dark-mode .table {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        /* Formularios */
        body.dark-mode .form-control {
            background-color: #333333;
            color: #ffffff;
            border: 1px solid #555555;
        }

        body.dark-mode .form-label {
            color: #b3b3b3;
        }

        /* Botones */
        body.dark-mode .btn {
            background-color: #555555;
            color: #ffffff;
            border-color: #444444;
        }

        /* Links */
        body.dark-mode a {
            color: #b3b3b3;
        }

        /* Alertas */
        body.dark-mode .alert {
            background-color: #2a2a2a;
            color: #ffffff;
            border-color: #444444;
        }

        /* Otros elementos específicos */
        body.dark-mode .dropdown-menu {
            background-color: #1e1e1e;
            color: #ffffff;
        }
    </style>
    <!-- VITE CSS -->
    @vite(['resources/sass/app.scss'])
    <!-- CSS -->
    @yield('css')
</head>

<body>
    <div class="wrapper">
        @include('layouts.app.nav')
        <div class="main">
            @include('layouts.app.usernav')
            @include('layouts.app.content')
            @include('layouts.app.footer')
        </div>
    </div>
    <!-- VITE Scripts -->
    @vite(['resources/js/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('toggle-dark-mode');
            const body = document.body;

            // Verifica si el usuario ya tiene una preferencia guardada
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'enabled') {
                body.classList.add('dark-mode');
                toggleButton.textContent = 'Modo Claro';
            }

            toggleButton.addEventListener('click', () => {
                body.classList.toggle('dark-mode');

                // Guarda la preferencia en el almacenamiento local
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                    toggleButton.textContent = 'Modo Claro';
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    toggleButton.textContent = 'Modo Oscuro';
                }
            });
        });
    </script>

    <!-- Blade Scripts Load -->
    @stack('scripts')
</body>

</html>
