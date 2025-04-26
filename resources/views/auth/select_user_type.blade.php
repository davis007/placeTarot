@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="material-card overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 text-lg font-medium">
                    {{ __('ユーザータイプを選択') }}
                </div>

                <div class="p-6 bg-white">
                    <p class="mb-4 text-gray-700">
                        {{ __('タロット練習場へようこそ！あなたのユーザータイプを選択してください。') }}
                    </p>

                    <form method="POST" action="{{ route('auth.google.select-user-type') }}">
                        @csrf
                        <input type="hidden" name="google_id" value="{{ $googleId }}">
                        <input type="hidden" name="name" value="{{ $name }}">
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="avatar" value="{{ $avatar }}">

                        <div class="mb-6">
                            <div class="mt-2 space-y-4">
                                <div class="border rounded-md p-4 hover:border-primary cursor-pointer">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="radio" name="user_type" value="client" class="mt-1 focus:ring-primary h-4 w-4 text-primary border-gray-300" checked>
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">{{ __('相談者') }}</span>
                                            <span class="block text-sm text-gray-500">タロット鑑定を受けたい方。鑑定師に質問を送り、タロットリーディングを受けることができます。</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="border rounded-md p-4 hover:border-primary cursor-pointer">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="radio" name="user_type" value="practitioner" class="mt-1 focus:ring-primary h-4 w-4 text-primary border-gray-300">
                                        <div class="ml-3">
                                            <span class="block text-sm font-medium text-gray-700">{{ __('占い師') }}</span>
                                            <span class="block text-sm text-gray-500">タロット鑑定を提供したい方。相談者からの質問に答え、タロットリーディングを行うことができます。</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-primary">
                                {{ __('続ける') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
