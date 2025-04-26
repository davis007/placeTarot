<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
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

        .mystical-bg {
            background: linear-gradient(to bottom, #0A0F1D, #4A2C6D);
            color: white;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <nav class="bg-primary text-white material-shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="text-xl font-bold flex items-center">
                                <img src="{{ asset('images/logo-compact.svg') }}" alt="Tarotique" class="h-8 w-auto mr-2" />
                            </a>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button x-data="{ open: false }" @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-secondary focus:outline-none transition duration-150 ease-in-out">
                            <span class="material-icons">menu</span>
                        </button>
                    </div>

                    <!-- Desktop menu -->
                    <div class="hidden sm:flex sm:items-center">
                        @guest
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-white hover:text-secondary px-3 py-2 rounded-md text-sm font-medium">
                                    {{ __('ログイン') }}
                                </a>
                            @endif

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-white hover:text-secondary px-3 py-2 rounded-md text-sm font-medium">
                                    {{ __('新規登録') }}
                                </a>
                            @endif
                        @else
                            <div x-data="{ open: false }" class="ml-3 relative">
                                <div>
                                    <button @click="open = !open" class="flex text-sm text-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary">
                                        <span class="material-icons">account_circle</span>
                                        <span class="ml-1">{{ Auth::user()->name }}</span>
                                        <span class="material-icons">arrow_drop_down</span>
                                    </button>
                                </div>

                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-background ring-1 ring-secondary ring-opacity-50 focus:outline-none z-50" style="display: none;">
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="block px-4 py-2 text-sm text-text hover:bg-accent1 hover:text-white">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden" x-data="{ open: false }" :class="{'block': open, 'hidden': !open}" style="display: none;">
                <div class="pt-2 pb-3 space-y-1">
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:text-secondary hover:bg-dark">
                                {{ __('ログイン') }}
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:text-secondary hover:bg-dark">
                                {{ __('新規登録') }}
                            </a>
                        @endif
                    @else
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block pl-3 pr-4 py-2 text-base font-medium text-white hover:text-white hover:bg-accent1">
                            {{ __('ログアウト') }}
                        </a>
                    @endguest
                </div>
            </div>
        </nav>

        <main class="flex-grow py-4">
            @yield('content')
        </main>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
