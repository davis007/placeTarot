<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'タロット練習場') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <!-- Webpackでコンパイルされたスクリプト -->
    <script src="{{ asset('js/bundle.js') }}" defer></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#6200EA',
                        secondary: '#FFD700',
                        accent: '#00BFA5',
                        background: '#FAFAFA',
                        text: '#212121',
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
            background-color: #FAFAFA;
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
            background-color: #6200EA;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #5000D0;
        }

        .btn-secondary {
            background-color: #FFD700;
            color: #212121;
            padding: 0.5rem 1.5rem;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #F0C800;
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
