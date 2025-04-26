@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="material-card overflow-hidden">
                <div class="bg-primary text-white px-6 py-4 text-lg font-medium">
                    {{ __('メールアドレスの確認') }}
                </div>

                <div class="p-6 bg-white">
                    @if (session('resent'))
                        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                            {{ __('新しい確認リンクがメールアドレスに送信されました。') }}
                        </div>
                    @endif

                    <p class="mb-4">
                        {{ __('続行する前に、確認リンクがあるかメールをご確認ください。') }}
                    </p>
                    <p class="mb-4">
                        {{ __('メールが届いていない場合は') }}、
                        <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="text-primary hover:underline">
                                {{ __('こちらをクリックして再送信してください') }}
                            </button>。
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
