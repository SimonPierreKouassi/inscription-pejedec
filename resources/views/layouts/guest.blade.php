<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RDV Manager') }} - @yield('title', 'Authentification')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta
        property="og:image"
        content="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    <meta
        property="og:description"
        content="Bienvenue sur le portail administrateur de pré-inscription du volet formation par apprentissage du PEJEDEC 3" />
    <meta
        name="description"
        content="Bienvenue sur le portail de pré-inscription du volet formation par apprentissage du PEJEDEC 3" />
    <meta property="og:title" content="Portail de connexion" />

    <!-- iPad Pro with high-resolution Retina display: -->
    <link
        rel="apple-touch-icon"
        sizes="167x167"
        href="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    <!-- 3x resolution iPhone: -->
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    <!-- non-Retina iPad, iPad mini, etc.: -->
    <link
        rel="apple-touch-icon"
        sizes="152x152"
        href="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    <!-- 2x resolution iPhone and other devices: -->
    <link rel="apple-touch-icon" href="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    <!-- basic favicon -->
    <link rel="icon" href="{{ Vite::asset('resources/images/logos/logo-pejedec.png')}}" />
    
    <!-- Additional CSS -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <!-- Scripts additionnels -->
    @stack('scripts')
</body>
</html>