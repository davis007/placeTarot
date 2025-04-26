@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="material-card overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 text-lg font-medium">
                    {{ __('パスワードの確認') }}
                </div>

                <div class="p-6 bg-white">
                    <p class="mb-4 text-gray-700">
                        {{ __('続行する前にパスワードを確認してください。') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

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

                        <div class="flex items-center justify-between">
                            <button type="submit" class="btn-primary">
                                {{ __('パスワードを確認') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary hover:text-primary-dark" href="{{ route('password.request') }}">
                                    {{ __('パスワードをお忘れですか？') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
