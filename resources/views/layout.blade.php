<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="Tells you where your colleague probably is">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-200 h-screen antialiased leading-none">
    <div id="app">
        <header>
            <div class="bg-blue-800 p-4 flex justify-between">
                <div class="flex w-3/4 max-w-lg">
                    <h1 class="text-white font-bold mr-4 mt-2 text-xl">Stripey</h1>
                    @yield('nav')
                </div>

                <div class="ml-4 rounded p-2 text-white flex" style="background-color:rgba(255, 255, 255, 0.1);">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}" heigth="24" width="24"
                         class="rounded-full">
                    <a href="{{ route('logout') }}" class="ml-2 align-baseline my-auto hover:underline">
                        Sign&nbsp;out
                    </a>
                </div>

            </div>
        </header>

        <main>
            @yield('main')
        </main>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</div>
</body>
</html>
