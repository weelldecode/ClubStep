<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  >

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-white">

    <flux:main container>

        {{ $slot }}
    </flux:main>


    @fluxScripts
</body>

</html>
