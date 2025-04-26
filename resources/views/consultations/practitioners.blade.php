<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('鑑定師を探す') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('ダッシュボードに戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">{{ __('利用可能な鑑定師') }}</h3>

                    @if($practitioners->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500">{{ __('現在利用可能な鑑定師はいません。') }}</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($practitioners as $practitioner)
                                <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                                    <div class="flex items-center mb-4">
                                        <div class="flex-shrink-0">
                                            @if($practitioner->profile && $practitioner->profile->avatar)
                                                <img class="h-12 w-12 rounded-full object-cover" src="{{ asset('storage/avatars/' . $practitioner->profile->avatar) }}" alt="{{ $practitioner->name }}">
                                            @else
                                                <div class="h-12 w-12 rounded-full bg-purple-100 flex items-center justify-center">
                                                    <span class="material-icons text-purple-600">person</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-lg font-semibold">{{ $practitioner->name }}</h4>
                                            <div class="flex items-center">
                                                <span class="material-icons text-yellow-400 text-sm">star</span>
                                                <span class="ml-1 text-sm">
                                                    {{ number_format($practitioner->receivedReviews()->avg('rating') ?? 0, 1) }}
                                                </span>
                                                <span class="ml-1 text-xs text-gray-500">
                                                    ({{ $practitioner->receivedReviews()->count() }}件)
                                                </span>
                                            </div>
                                        </div>
                                        @if($practitioner->isExpert())
                                            <span class="ml-auto px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                                優良鑑定師
                                            </span>
                                        @endif
                                    </div>

                                    @if($practitioner->profile && $practitioner->profile->specialties)
                                        <div class="mb-4">
                                            <h5 class="text-sm font-medium text-gray-700 mb-1">{{ __('得意分野') }}</h5>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($practitioner->profile->specialties as $specialty)
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                        {{ $specialty }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($practitioner->profile && $practitioner->profile->bio)
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-600 line-clamp-3">{{ $practitioner->profile->bio }}</p>
                                        </div>
                                    @endif

                                    <div class="mt-4 text-center">
                                        <a href="{{ route('practitioners.show', $practitioner) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            {{ __('プロフィールを見る') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $practitioners->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
