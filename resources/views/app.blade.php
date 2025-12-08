<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('branding.app_name', config('app.name', 'NR Tickets')) }}</title>

        @php($logos = config('branding.logos'))
        @if(!empty($logos['favicon']))
            @php($ext = pathinfo($logos['favicon'], PATHINFO_EXTENSION))
            @php($type = $ext === 'svg' ? 'image/svg+xml' : ($ext === 'png' ? 'image/png' : 'image/x-icon'))
            <link rel="icon" type="{{ $type }}" href="{{ $logos['favicon'] }}">
            <link rel="shortcut icon" href="{{ $logos['favicon'] }}">
        @endif

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Dark Mode Script (prevents flash) -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>

        <!-- Dynamic Branding Colors injected from config/branding.php -->
        @php($colors = config('branding.colors'))
        <style>
            :root {
                /* Primary */
                @foreach(($colors['primary'] ?? []) as $shade => $hex)
                --color-primary-{{ $shade }}: {{ $hex }};
                @endforeach
                /* Secondary */
                @foreach(($colors['secondary'] ?? []) as $shade => $hex)
                --color-secondary-{{ $shade }}: {{ $hex }};
                @endforeach
                /* Accent */
                @foreach(($colors['accent'] ?? []) as $shade => $hex)
                --color-accent-{{ $shade }}: {{ $hex }};
                @endforeach
            }
        </style>

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
