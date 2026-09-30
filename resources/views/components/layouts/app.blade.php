@props(['title' => 'CineMatch'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} · CineMatch</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-ink text-mist antialiased">
        <div class="flex min-h-screen flex-col">
            <x-navbar />
            <main class="flex-1">
                {{ $slot }}
            </main>
            <x-footer />
        </div>
    </body>
</html>
