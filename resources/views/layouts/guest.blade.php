<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Apexio') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    
    <body class="bg-light">
        <div class="container">
            <div class="row min-vh-100 d-flex justify-content-center align-items-center">
                <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                    
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none text-dark">
                            <h1 class="h3 fw-bold">Apexio</h1>
                        </a>
                    </div>

                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body p-4 p-sm-5">
                            {{ $slot }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>