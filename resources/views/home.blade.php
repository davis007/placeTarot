@extends('components.app-layout')

@section('content')
<div class="bg-gradient-to-r from-purple-900 to-indigo-800 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">タロット練習場へようこそ</h1>
            <p class="text-xl mb-8">タロット鑑定の練習生と相談者をつなぐプラットフォーム</p>

            <div class="flex justify-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-secondary flex items-center">
                        <span class="material-icons mr-1">dashboard</span>
                        ダッシュボードへ
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn-secondary flex items-center">
                        <span class="material-icons mr-1">person_add</span>
                        新規登録
                    </a>
                    <a href="{{ route('login') }}" class="bg-white text-primary px-6 py-2 rounded-md font-medium flex items-center">
                        <span class="material-icons mr-1">login</span>
                        ログイン
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">タロット練習場の特徴</h2>
            <p class="text-lg text-gray-600">タロット鑑定の練習生と相談者、双方にメリットのあるプラットフォームです</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="material-card p-6">
                <div class="text-primary text-center mb-4">
                    <span class="material-icons text-5xl">school</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">練習生の実践の場</h3>
                <p class="text-gray-600">
                    タロット講座の受講生が実践経験を積むための場を提供します。
                    実際の相談に応えることでスキルアップを目指せます。
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="material-card p-6">
                <div class="text-primary text-center mb-4">
                    <span class="material-icons text-5xl">question_answer</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">無料で鑑定を受けられる</h3>
                <p class="text-gray-600">
                    相談者は無料で鑑定を受けることができます。
                    気軽に悩みを相談し、タロットの視点からのアドバイスを得られます。
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="material-card p-6">
                <div class="text-primary text-center mb-4">
                    <span class="material-icons text-5xl">stars</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">ポイントシステム</h3>
                <p class="text-gray-600">
                    良い鑑定をした練習生はポイントを獲得。
                    一定ポイントで「優良鑑定師」として認定され、有料鑑定も可能に。
                </p>
            </div>
        </div>
    </div>
</div>

<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">ご利用の流れ</h2>
            <p class="text-lg text-gray-600">簡単3ステップで鑑定を依頼・実施できます</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex justify-center items-center w-12 h-12 rounded-full bg-primary text-white mb-4 mx-auto">
                    <span>1</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">アカウント登録</h3>
                <p class="text-gray-600 text-center">
                    相談者または練習生として登録し、プロフィールを設定します。
                </p>
            </div>

            <!-- Step 2 -->
            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex justify-center items-center w-12 h-12 rounded-full bg-primary text-white mb-4 mx-auto">
                    <span>2</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">鑑定依頼・承認</h3>
                <p class="text-gray-600 text-center">
                    相談者が練習生を選んで鑑定を依頼し、練習生が承認します。
                </p>
            </div>

            <!-- Step 3 -->
            <div class="bg-white rounded-lg p-6 shadow-md">
                <div class="flex justify-center items-center w-12 h-12 rounded-full bg-primary text-white mb-4 mx-auto">
                    <span>3</span>
                </div>
                <h3 class="text-xl font-bold text-center mb-2">鑑定・レビュー</h3>
                <p class="text-gray-600 text-center">
                    メッセージ機能で鑑定を行い、完了後に相談者がレビューを投稿します。
                </p>
            </div>
        </div>
    </div>
</div>

<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">今すぐ始めましょう</h2>

        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary flex items-center justify-center">
                    <span class="material-icons mr-1">dashboard</span>
                    ダッシュボードへ
                </a>
            @else
                <a href="{{ route('register') }}" class="btn-primary flex items-center justify-center">
                    <span class="material-icons mr-1">person_add</span>
                    新規登録
                </a>
                <a href="{{ route('login') }}" class="btn-secondary flex items-center justify-center">
                    <span class="material-icons mr-1">login</span>
                    ログイン
                </a>
            @endauth
        </div>
    </div>
</div>
@endsection
