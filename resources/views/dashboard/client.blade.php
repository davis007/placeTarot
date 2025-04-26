@extends('components.app-layout')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">相談者ダッシュボード</h1>
        
        <!-- Points Summary -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">ポイント残高</h2>
                    <p class="text-gray-600">現在のポイント残高を確認できます</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-primary">{{ number_format($points) }} P</p>
                    <a href="{{ route('points.purchase.form') }}" class="text-sm text-primary hover:underline">ポイントを購入する</a>
                </div>
            </div>
        </div>
        
        <!-- Active Consultations -->
        <h2 class="text-xl font-semibold text-gray-900 mb-4">進行中の鑑定</h2>
        
        @if($activeConsultations->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
                <p class="text-gray-600">現在進行中の鑑定はありません。</p>
                <a href="{{ route('practitioners.index') }}" class="mt-4 inline-block btn-primary">
                    <span class="material-icons mr-1">search</span>
                    鑑定師を探す
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($activeConsultations as $consultation)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $consultation->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    鑑定師: {{ $consultation->practitioner->name }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($consultation->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($consultation->status === 'accepted') bg-blue-100 text-blue-800
                                @elseif($consultation->status === 'in_progress') bg-green-100 text-green-800
                                @endif">
                                @if($consultation->status === 'pending') 承認待ち
                                @elseif($consultation->status === 'accepted') 承認済み
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
                                @if($consultation->status !== 'pending')
                                    <a href="{{ route('messages.index', $consultation) }}" class="ml-4 text-primary hover:underline text-sm">
                                        メッセージ
                                    </a>
                                @endif
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
        
        <!-- Recommended Practitioners -->
        <h2 class="text-xl font-semibold text-gray-900 mb-4">おすすめの鑑定師</h2>
        
        @if($recommendedPractitioners->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 text-center">
                <p class="text-gray-600">現在おすすめの鑑定師はいません。</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @foreach($recommendedPractitioners as $practitioner)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex flex-col items-center mb-4">
                            <div class="w-20 h-20 rounded-full bg-primary text-white flex items-center justify-center mb-2">
                                @if($practitioner->profile && $practitioner->profile->avatar)
                                    <img src="{{ $practitioner->profile->avatar }}" alt="{{ $practitioner->name }}" class="w-full h-full rounded-full object-cover">
                                @else
                                    <span class="material-icons text-4xl">person</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold">{{ $practitioner->name }}</h3>
                            <div class="flex items-center mt-1">
                                <span class="material-icons text-yellow-400">star</span>
                                <span class="ml-1">{{ number_format($practitioner->average_rating ?? 0, 1) }}</span>
                                <span class="ml-2 text-sm text-gray-500">({{ $practitioner->review_count ?? 0 }}件)</span>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <a href="{{ route('practitioners.show', $practitioner) }}" class="btn-primary inline-block">
                                プロフィールを見る
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="text-center">
                <a href="{{ route('practitioners.index') }}" class="btn-secondary inline-block">
                    <span class="material-icons mr-1">search</span>
                    鑑定師をもっと探す
                </a>
            </div>
        @endif
        
        <!-- Completed Consultations -->
        @if(!$completedConsultations->isEmpty())
            <h2 class="text-xl font-semibold text-gray-900 mt-8 mb-4">完了した鑑定</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @foreach($completedConsultations as $consultation)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $consultation->title }}</h3>
                                <p class="text-sm text-gray-500">
                                    鑑定師: {{ $consultation->practitioner->name }}
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                完了
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $consultation->question }}</p>
                        
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
