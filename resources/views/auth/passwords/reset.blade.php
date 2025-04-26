@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="material-card overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 text-lg font-medium">
                    {{ __('パスワードのリセット') }}
                </div>

                <div class="p-6 bg-white">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-6">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('メールアドレス') }}
                            </label>
                            <input id="email" type="email"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('email') border-red-500 @enderror"
                                name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('新しいパスワード') }}
                            </label>
                            <input id="password" type="password"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary @error('password') border-red-500 @enderror"
                                name="password" required autocomplete="new-password">

                            @error('password')
                                <p class="mt-1 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('新しいパスワード（確認）') }}
                            </label>
                            <input id="password-confirm" type="password"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary"
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="btn-primary">
                                {{ __('パスワードをリセット') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
