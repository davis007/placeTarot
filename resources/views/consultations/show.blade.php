<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('鑑定詳細') }}
            </h2>
            <a href="{{ route('consultations.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('鑑定一覧に戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $consultation->title }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('作成日') }}: {{ $consultation->created_at->format('Y/m/d H:i') }}
                            </p>
                        </div>
                        <div class="px-3 py-1 text-sm rounded-full 
                            @if($consultation->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($consultation->status === 'accepted') bg-blue-100 text-blue-800
                            @elseif($consultation->status === 'in_progress') bg-green-100 text-green-800
                            @elseif($consultation->status === 'completed') bg-gray-100 text-gray-800
                            @elseif($consultation->status === 'rejected') bg-red-100 text-red-800
                            @elseif($consultation->status === 'cancelled') bg-gray-100 text-gray-800
                            @endif">
                            {{ __('status.' . $consultation->status) }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('相談者情報') }}</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">{{ __('名前') }}:</span> {{ $consultation->client->name }}</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('鑑定師情報') }}</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p><span class="font-medium">{{ __('名前') }}:</span> {{ $consultation->practitioner->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-2">{{ __('質問内容') }}</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="whitespace-pre-wrap">{{ $consultation->question }}</p>
                        </div>
                    </div>

                    <!-- メッセージセクション -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="text-md font-medium text-gray-900">{{ __('メッセージ') }}</h4>
                            
                            @if(in_array($consultation->status, ['accepted', 'in_progress', 'completed']))
                                <a href="{{ route('messages.index', $consultation) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('メッセージを表示') }}
                                    @if($unreadMessageCount > 0)
                                        <span class="ml-2 bg-red-500 text-white rounded-full px-2 py-0.5 text-xs">{{ $unreadMessageCount }}</span>
                                    @endif
                                </a>
                            @endif
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            @if($messageCount > 0)
                                <p>{{ __('全') }} {{ $messageCount }} {{ __('件のメッセージがあります。') }}</p>
                                @if($unreadMessageCount > 0)
                                    <p class="text-red-600">{{ __('未読メッセージが') }} {{ $unreadMessageCount }} {{ __('件あります。') }}</p>
                                @endif
                            @else
                                <p>{{ __('まだメッセージはありません。') }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- アクションボタン -->
                    <div class="mt-8 flex justify-end space-x-4">
                        @if($consultation->status === 'pending' && Auth::id() === $consultation->practitioner_id)
                            <form method="POST" action="{{ route('consultations.accept', $consultation) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('承認する') }}
                                </button>
                            </form>
                        @endif

                        @if(in_array($consultation->status, ['accepted', 'in_progress']) && Auth::id() === $consultation->practitioner_id)
                            <form method="POST" action="{{ route('consultations.complete', $consultation) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('鑑定を完了する') }}
                                </button>
                            </form>
                        @endif

                        @if(in_array($consultation->status, ['pending', 'accepted']) && Auth::id() === $consultation->client_id)
                            <form method="POST" action="{{ route('consultations.cancel', $consultation) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('本当にキャンセルしますか？')" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('キャンセルする') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
