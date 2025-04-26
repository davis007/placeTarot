@extends('components.app-layout')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">鑑定師ダッシュボード</h1>
        
        <!-- Stats Summary -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Points -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-800 mr-4">
                        <span class="material-icons">stars</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">獲得ポイント</p>
                        <p class="text-2xl font-bold">{{ number_format($points) }} P</p>
                    </div>
                </div>
            </div>
            
            <!-- Reviews -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-800 mr-4">
                        <span class="material-icons">rate_review</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">レビュー数</p>
                        <p class="text-2xl font-bold">{{ $totalReviews }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Rating -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-800 mr-4">
                        <span class="material-icons">star</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">平均評価</p>
                        <p class="text-2xl font-bold">{{ number_format($averageRating, 1) }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Badges -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-800 mr-4">
                        <span class="material-icons">military_tech</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">獲得バッジ</p>
                        <p class="text-2xl font-bold">{{ $badges->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Consultations -->
        <h2 class="text-xl font-semibold text-gray-900 mb-4">承認待ちの鑑定依頼</h2>
        
        @if($pendingConsultations->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
                <p class="text-gray-600">現在承認待ちの鑑定依頼はありません。</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($pendingConsultations as $consultation)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $consultation->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    相談者: {{ $consultation->client->name }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                承認待ち
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $consultation->question }}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $consultation->created_at->format('Y/m/d') }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('consultations.show', $consultation) }}" class="text-primary hover:underline text-sm">
                                    詳細を見る
                                </a>
                                <form action="{{ route('consultations.accept', $consultation) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-4 btn-primary text-sm py-1 px-3">
                                        承認する
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <!-- Active Consultations -->
        <h2 class="text-xl font-semibold text-gray-900 mb-4">進行中の鑑定</h2>
        
        @if($activeConsultations->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
                <p class="text-gray-600">現在進行中の鑑定はありません。</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($activeConsultations as $consultation)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $consultation->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    相談者: {{ $consultation->client->name }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($consultation->status === 'accepted') bg-blue-100 text-blue-800
                                @elseif($consultation->status === 'in_progress') bg-green-100 text-green-800
                                @endif">
                                @if($consultation->status === 'accepted') 承認済み
                                @elseif($consultation->status === 'in_progress') 進行中
                                @endif
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $consultation->question }}</p>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $consultation->created_at->format('Y/m/d') }}</span>
                            <div>
                                <a href="{{ route('consultations.show', $consultation) }}" class="text-primary hover:underline text-sm">
                                    詳細を見る
                                </a>
                                <a href="{{ route('messages.index', $consultation) }}" class="ml-4 text-primary hover:underline text-sm">
                                    メッセージ
                                </a>
                                <form action="{{ route('consultations.complete', $consultation) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="ml-4 btn-secondary text-sm py-1 px-3">
                                        完了する
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center mb-8">
                <a href="{{ route('consultations.index') }}" class="text-primary hover:underline">
                    すべての鑑定を見る
                </a>
            </div>
        @endif
        
        <!-- Badges -->
        @if(!$badges->isEmpty())
            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">獲得バッジ</h2>
            
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($badges as $badge)
                        <div class="flex flex-col items-center p-4 border rounded-lg">
                            <div class="w-16 h-16 flex items-center justify-center mb-2">
                                <img src="{{ $badge->icon }}" alt="{{ $badge->name }}" class="max-w-full max-h-full">
                            </div>
                            <h3 class="font-semibold text-center">{{ $badge->name }}</h3>
                            <p class="text-xs text-gray-500 text-center">{{ $badge->pivot->acquired_at->format('Y/m/d') }}獲得</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        
        <!-- Recent Completed Consultations -->
        @if(!$completedConsultations->isEmpty())
            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">最近完了した鑑定</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($completedConsultations as $consultation)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $consultation->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    相談者: {{ $consultation->client->name }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                完了
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $consultation->question }}</p>
                        
                        @if($consultation->review)
                            <div class="mb-4 p-3 bg-gray-50 rounded-md">
                                <div class="flex items-center mb-2">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-icons text-yellow-400">
                                                {{ $i <= $consultation->review->rating ? 'star' : 'star_border' }}
                                            </span>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600">{{ $consultation->review->created_at->format('Y/m/d') }}</span>
                                </div>
                                <p class="text-sm text-gray-700">{{ $consultation->review->comment }}</p>
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $consultation->completed_at->format('Y/m/d') }}</span>
                            <div>
                                <a href="{{ route('consultations.show', $consultation) }}" class="text-primary hover:underline text-sm">
                                    詳細を見る
                                </a>
                                <a href="{{ route('messages.index', $consultation) }}" class="ml-4 text-primary hover:underline text-sm">
                                    メッセージ
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
