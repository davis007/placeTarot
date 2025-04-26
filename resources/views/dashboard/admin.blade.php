@extends('components.app-layout')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">管理者ダッシュボード</h1>
        
        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                        <span class="material-icons">people</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">総ユーザー数</p>
                        <p class="text-2xl font-bold">{{ number_format($totalUsers) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Consultations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-800 mr-4">
                        <span class="material-icons">question_answer</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">総鑑定数</p>
                        <p class="text-2xl font-bold">{{ number_format($totalConsultations) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Pending Consultations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                        <span class="material-icons">pending</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">承認待ち鑑定</p>
                        <p class="text-2xl font-bold">{{ number_format($pendingConsultations) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Completed Consultations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                        <span class="material-icons">check_circle</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">完了鑑定</p>
                        <p class="text-2xl font-bold">{{ number_format($completedConsultations) }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Links -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">管理メニュー</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border rounded-lg hover:bg-gray-50">
                    <span class="material-icons text-primary mr-3">people</span>
                    <div>
                        <h3 class="font-semibold">ユーザー管理</h3>
                        <p class="text-sm text-gray-600">ユーザーの一覧・編集・削除</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.consultations.index') }}" class="flex items-center p-4 border rounded-lg hover:bg-gray-50">
                    <span class="material-icons text-primary mr-3">question_answer</span>
                    <div>
                        <h3 class="font-semibold">鑑定管理</h3>
                        <p class="text-sm text-gray-600">鑑定の一覧・詳細・状態変更</p>
                    </div>
                </a>
                
                <a href="{{ route('admin.badges.index') }}" class="flex items-center p-4 border rounded-lg hover:bg-gray-50">
                    <span class="material-icons text-primary mr-3">military_tech</span>
                    <div>
                        <h3 class="font-semibold">バッジ管理</h3>
                        <p class="text-sm text-gray-600">バッジの作成・編集・削除</p>
                    </div>
                </a>
            </div>
        </div>
        
        <!-- System Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">システム情報</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-2">アプリケーション情報</h3>
                    <table class="w-full">
                        <tr>
                            <td class="py-2 text-gray-600">Laravel バージョン</td>
                            <td class="py-2">{{ app()->version() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-600">PHP バージョン</td>
                            <td class="py-2">{{ phpversion() }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-600">環境</td>
                            <td class="py-2">{{ app()->environment() }}</td>
                        </tr>
                    </table>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">データベース情報</h3>
                    <table class="w-full">
                        <tr>
                            <td class="py-2 text-gray-600">接続</td>
                            <td class="py-2">{{ config('database.default') }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 text-gray-600">データベース名</td>
                            <td class="py-2">{{ config('database.connections.' . config('database.default') . '.database') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
