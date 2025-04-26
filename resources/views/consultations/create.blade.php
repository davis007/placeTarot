<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('鑑定依頼') }}
            </h2>
            <a href="{{ route('practitioners.show', $practitioner) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('プロフィールに戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col md:flex-row">
                        <!-- 左側：鑑定師情報 -->
                        <div class="md:w-1/3 mb-6 md:mb-0 md:pr-6">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <div class="flex flex-col items-center mb-6">
                                    @if($practitioner->profile && $practitioner->profile->avatar)
                                        <img class="h-24 w-24 rounded-full object-cover mb-4" src="{{ asset('storage/avatars/' . $practitioner->profile->avatar) }}" alt="{{ $practitioner->name }}">
                                    @else
                                        <div class="h-24 w-24 rounded-full bg-purple-100 flex items-center justify-center mb-4">
                                            <span class="material-icons text-purple-600 text-4xl">person</span>
                                        </div>
                                    @endif
                                    <h3 class="text-lg font-semibold">{{ $practitioner->name }}</h3>
                                    
                                    <div class="flex items-center mt-2">
                                        <span class="material-icons text-yellow-400">star</span>
                                        <span class="ml-1">
                                            {{ number_format($practitioner->receivedReviews()->avg('rating') ?? 0, 1) }}
                                        </span>
                                        <span class="ml-1 text-sm text-gray-500">
                                            ({{ $practitioner->receivedReviews()->count() }}件)
                                        </span>
                                    </div>
                                    
                                    @if($practitioner->isExpert())
                                        <span class="mt-2 px-3 py-1 text-sm rounded-full bg-purple-100 text-purple-800">
                                            優良鑑定師
                                        </span>
                                    @endif
                                </div>
                                
                                @if($practitioner->profile && $practitioner->profile->specialties)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">{{ __('得意分野') }}</h4>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($practitioner->profile->specialties as $specialty)
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    {{ $specialty }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- 右側：依頼フォーム -->
                        <div class="md:w-2/3">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('鑑定依頼フォーム') }}</h3>
                            
                            <form method="POST" action="{{ route('consultations.store') }}">
                                @csrf
                                <input type="hidden" name="practitioner_id" value="{{ $practitioner->id }}">
                                
                                <div class="mb-4">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">{{ __('タイトル') }}</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    @error('title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="question" class="block text-sm font-medium text-gray-700 mb-1">{{ __('質問内容') }}</label>
                                    <textarea name="question" id="question" rows="6" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('question') }}</textarea>
                                    @error('question')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-6">
                                    <p class="text-sm text-gray-600">
                                        {{ __('※鑑定依頼を送信すると、鑑定師からの承認を待つことになります。承認されると鑑定が開始されます。') }}
                                    </p>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('依頼を送信する') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
