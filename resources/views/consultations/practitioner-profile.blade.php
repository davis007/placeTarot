<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('鑑定師プロフィール') }}
            </h2>
            <a href="{{ route('practitioners.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('鑑定師一覧に戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <!-- 左側：プロフィール情報 -->
                        <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="flex flex-col items-center mb-6">
                                    @if($profile && $profile->avatar)
                                        <img class="h-32 w-32 rounded-full object-cover mb-4" src="{{ asset('storage/avatars/' . $profile->avatar) }}" alt="{{ $practitioner->name }}">
                                    @else
                                        <div class="h-32 w-32 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                                            <span class="material-icons text-purple-600 text-5xl">person</span>
                                        </div>
                                    @endif
                                    <h3 class="text-xl font-semibold">{{ $practitioner->name }}</h3>
                                    
                                    <div class="flex items-center mt-2">
                                        <span class="material-icons text-yellow-400">star</span>
                                        <span class="ml-1">
                                            {{ number_format($practitioner->receivedReviews()->avg('rating') ?? 0, 1) }}
                                        </span>
                                        <span class="ml-1 text-sm text-gray-500">
                                            ({{ $practitioner->receivedReviews()->count() }}件のレビュー)
                                        </span>
                                    </div>
                                    
                                    @if($practitioner->isExpert())
                                        <span class="mt-2 px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                            優良鑑定師
                                        </span>
                                    @endif
                                </div>
                                
                                @if($profile && $profile->specialties)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ __('得意分野') }}</h4>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($profile->specialties as $specialty)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    {{ $specialty }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                @if($profile && $profile->response_time)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-1">{{ __('平均応答時間') }}</h4>
                                        <p class="text-sm text-gray-600">{{ $profile->response_time }}</p>
                                    </div>
                                @endif
                                
                                <div class="mt-6">
                                    <a href="{{ route('consultations.create', $practitioner) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('鑑定を依頼する') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 右側：自己紹介とレビュー -->
                        <div class="md:w-2/3">
                            @if($profile && $profile->bio)
                                <div class="mb-8">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('自己紹介') }}</h3>
                                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                                        <p class="text-gray-600 whitespace-pre-line">{{ $profile->bio }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- レビュー -->
                            <div>
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ __('レビュー') }}</h3>
                                    <a href="{{ route('reviews.index', $practitioner) }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                                        {{ __('すべてのレビューを見る') }}
                                    </a>
                                </div>
                                
                                @if($reviews->isEmpty())
                                    <div class="bg-white p-4 rounded-lg border border-gray-200 text-center">
                                        <p class="text-gray-500">{{ __('まだレビューはありません。') }}</p>
                                    </div>
                                @else
                                    <div class="space-y-4">
                                        @foreach($reviews as $review)
                                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                                <div class="flex justify-between items-start mb-2">
                                                    <div>
                                                        <div class="flex items-center">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                <span class="material-icons text-yellow-400 text-sm">
                                                                    {{ $i <= $review->rating ? 'star' : 'star_border' }}
                                                                </span>
                                                            @endfor
                                                        </div>
                                                        <p class="text-sm text-gray-500 mt-1">
                                                            {{ $review->client->name }} - {{ $review->created_at->format('Y/m/d') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <p class="text-gray-600">{{ $review->comment }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
