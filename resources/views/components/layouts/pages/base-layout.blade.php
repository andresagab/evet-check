<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        {{-- meta --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- tab title --}}
        <title>{{ strlen($tabTitle) > 0 ? "$tabTitle | " : null }} {{ config('app.name', 'Event-Check') }}</title>

        {{-- styles --}}
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">

        {{-- vite --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- livewire --}}
        <livewire:styles/>

    </head>
    <body class="bg-gray-100 dark:bg-gray-900">

        {{-- header --}}
        @section('header')
        @show

        {{-- main --}}
        <main>{{ $slot }}</main>

        {{-- footer --}}
        @section('footer')
        @show

        {{-- livewire scripts --}}
        <livewire:scripts/>

        {{-- sweet alert listeners --}}
        <script>

            /**
             * Toast message, this can be called from wire component
             */
            Livewire.on('toast', function (data) {

                // if !data.icon set it
                if (!data.icon)
                    data.icon = 'success'

                Toast.fire({
                    title: data.title,
                    icon: data.icon
                });
            });

            /**
             * Alert message, this can be called from wire component
             */
            Livewire.on('alert', function (data) {

                // if !data.icon set it
                if (!data.icon)
                    data.icon = 'success'

                SAlert(data)

            });

        </script>

    </body>
</html>
