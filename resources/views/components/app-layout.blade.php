<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Tarotique') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon.svg') }}" type="image/svg+xml">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <!-- Webpackでコンパイルされたスクリプト -->
    <script src="{{ asset('js/bundle.js') }}" defer></script>


    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4A2C6D',
                        secondary: '#D4AF37',
                        accent1: '#800020',
                        accent2: '#008080',
                        background: '#F8F6F0',
                        text: '#212121',
                        dark: '#0A0F1D',
                    },
                    fontFamily: {
                        sans: ['Noto Sans JP', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Noto Sans JP', sans-serif;
            background-color: #F8F6F0;
            color: #212121;
        }

        .material-shadow {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .material-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .material-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background-color: #4A2C6D;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3A2255;
        }

        .btn-secondary {
            background-color: #D4AF37;
            color: #212121;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #C09F2F;
        }

        .btn-accent1 {
            background-color: #800020;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-accent1:hover {
            background-color: #6A001A;
        }

        .btn-accent2 {
            background-color: #008080;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-accent2:hover {
            background-color: #006666;
        }

        .tarot-card {
            border: 2px solid #D4AF37;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .tarot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .mystical-bg {
            background: linear-gradient(to bottom, #0A0F1D, #4A2C6D);
            color: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        @include('components.navigation')

        <!-- Page Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer -->
        @include('components.footer')
    </div>
</body>
</html>
