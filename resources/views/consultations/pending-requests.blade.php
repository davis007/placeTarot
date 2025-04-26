<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('承認待ちの鑑定依頼') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('ダッシュボードに戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900">{{ __('承認待ちの鑑定依頼') }}</h3>
            </div>

            @if($pendingConsultations->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 text-center">
                        <p class="text-gray-500">{{ __('現在承認待ちの鑑定依頼はありません。') }}</p>
                    </div>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($pendingConsultations as $consultation)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="text-lg font-semibold">{{ $consultation->title }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ __('相談者') }}: {{ $consultation->client->name }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                        {{ __('承認待ち') }}
                                    </span>
                                </div>
                                
                                <p class="text-gray-600 mb-4">{{ $consultation->question }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">{{ $consultation->created_at->format('Y/m/d H:i') }}</span>
                                    <div class="flex space-x-4">
                                        <a href="{{ route('consultations.show', $consultation) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                            {{ __('詳細を見る') }}
                                        </a>
                                        <form action="{{ route('consultations.accept', $consultation) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm">
                                                {{ __('承認する') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $pendingConsultations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
