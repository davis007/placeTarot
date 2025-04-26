<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('鑑定メッセージ') }} - {{ $consultation->title }}
            </h2>
            <a href="{{ route('consultations.show', $consultation) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('鑑定詳細に戻る') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- 鑑定情報 -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center mb-2">
                            <div class="font-semibold text-lg">{{ $consultation->title }}</div>
                            <div class="ml-auto px-2 py-1 text-xs rounded-full 
                                @if($consultation->status === 'in_progress') bg-green-100 text-green-800
                                @elseif($consultation->status === 'accepted') bg-blue-100 text-blue-800
                                @elseif($consultation->status === 'completed') bg-gray-100 text-gray-800
                                @endif">
                                {{ __('status.' . $consultation->status) }}
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p><span class="font-medium">相談者:</span> {{ $consultation->client->name }}</p>
                            <p><span class="font-medium">鑑定師:</span> {{ $consultation->practitioner->name }}</p>
                            <p><span class="font-medium">質問:</span> {{ $consultation->question }}</p>
                        </div>
                    </div>

                    <!-- メッセージ履歴 -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium mb-4">{{ __('メッセージ履歴') }}</h3>
                        
                        <div class="space-y-4 max-h-96 overflow-y-auto p-2" id="message-container">
                            @forelse ($messages as $message)
                                <div class="flex {{ $message->sender_id === Auth::id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-md px-4 py-2 rounded-lg 
                                        {{ $message->sender_id === Auth::id() 
                                            ? 'bg-indigo-100 text-indigo-900' 
                                            : 'bg-gray-100 text-gray-900' }}">
                                        <div class="flex items-center mb-1">
                                            <span class="font-medium text-sm">{{ $message->sender->name }}</span>
                                            <span class="ml-2 text-xs text-gray-500">{{ $message->created_at->format('Y/m/d H:i') }}</span>
                                        </div>
                                        <p class="whitespace-pre-wrap">{{ $message->body }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">{{ __('メッセージはまだありません。') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- メッセージ送信フォーム -->
                    @if(in_array($consultation->status, ['accepted', 'in_progress']))
                        <div class="mt-6">
                            <h3 class="text-lg font-medium mb-4">{{ __('メッセージを送信') }}</h3>
                            
                            <form method="POST" action="{{ route('messages.store', $consultation) }}">
                                @csrf
                                
                                <div class="mb-4">
                                    <textarea
                                        name="body"
                                        rows="4"
                                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        placeholder="{{ __('メッセージを入力してください...') }}"
                                        required
                                    >{{ old('body') }}</textarea>
                                    
                                    @error('body')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('送信') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="mt-6 p-4 bg-yellow-50 text-yellow-700 rounded-lg">
                            <p>{{ __('この鑑定は現在メッセージを送信できません。') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // ページ読み込み時にメッセージ履歴の最下部にスクロール
        document.addEventListener('DOMContentLoaded', function() {
            const messageContainer = document.getElementById('message-container');
            messageContainer.scrollTop = messageContainer.scrollHeight;
        });
    </script>
    @endpush
</x-app-layout>
