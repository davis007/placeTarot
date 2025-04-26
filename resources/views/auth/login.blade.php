@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="material-card overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 text-lg font-medium">
                    {{ __('ログイン') }}
                </div>

                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('メールアドレス') }}
                            </label>
                            <input id="email" type="email"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('パスワード') }}
                            </label>
                            <input id="password" type="password"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                                name="password" required autocomplete="current-password">

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input id="remember" type="checkbox"
                                    class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
                                    name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="ml-2 block text-sm text-gray-700">
                                    {{ __('ログイン状態を保存') }}
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="btn-primary">
                                {{ __('ログイン') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary hover:text-primary-dark" href="{{ route('password.request') }}">
                                    {{ __('パスワードをお忘れですか？') }}
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">{{ __('または') }}</span>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('auth.google') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                                    <g transform="matrix(1, 0, 0, 1, 27.009001, -39.238998)">
                                        <path fill="#4285F4" d="M -3.264 51.509 C -3.264 50.719 -3.334 49.969 -3.454 49.239 L -14.754 49.239 L -14.754 53.749 L -8.284 53.749 C -8.574 55.229 -9.424 56.479 -10.684 57.329 L -10.684 60.329 L -6.824 60.329 C -4.564 58.239 -3.264 55.159 -3.264 51.509 Z"/>
                                        <path fill="#34A853" d="M -14.754 63.239 C -11.514 63.239 -8.804 62.159 -6.824 60.329 L -10.684 57.329 C -11.764 58.049 -13.134 58.489 -14.754 58.489 C -17.884 58.489 -20.534 56.379 -21.484 53.529 L -25.464 53.529 L -25.464 56.619 C -23.494 60.539 -19.444 63.239 -14.754 63.239 Z"/>
                                        <path fill="#FBBC05" d="M -21.484 53.529 C -21.734 52.809 -21.864 52.039 -21.864 51.239 C -21.864 50.439 -21.724 49.669 -21.484 48.949 L -21.484 45.859 L -25.464 45.859 C -26.284 47.479 -26.754 49.299 -26.754 51.239 C -26.754 53.179 -26.284 54.999 -25.464 56.619 L -21.484 53.529 Z"/>
                                        <path fill="#EA4335" d="M -14.754 43.989 C -12.984 43.989 -11.404 44.599 -10.154 45.789 L -6.734 42.369 C -8.804 40.429 -11.514 39.239 -14.754 39.239 C -19.444 39.239 -23.494 41.939 -25.464 45.859 L -21.484 48.949 C -20.534 46.099 -17.884 43.989 -14.754 43.989 Z"/>
                                    </g>
                                </svg>
                                {{ __('Googleでログイン') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
