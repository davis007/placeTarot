<footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Site Info -->
            <div>
                <h3 class="text-xl font-bold mb-4">タロット練習場</h3>
                <p class="text-gray-300 mb-4">
                    タロット講座の受講生が実践経験を積むためのプラットフォームです。
                    鑑定を受けたい方と鑑定の練習をしたい方をつなぎます。
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4">クイックリンク</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-white">
                            ホーム
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">
                                ダッシュボード
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consultations.index') }}" class="text-gray-300 hover:text-white">
                                鑑定一覧
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('points.index') }}" class="text-gray-300 hover:text-white">
                                ポイント
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-white">
                                ログイン
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-gray-300 hover:text-white">
                                新規登録
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
            
            <!-- Contact & Legal -->
            <div>
                <h3 class="text-lg font-bold mb-4">お問い合わせ・規約</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-gray-300 hover:text-white">
                            お問い合わせ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-white">
                            利用規約
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-white">
                            プライバシーポリシー
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} タロット練習場. All rights reserved.</p>
        </div>
    </div>
</footer>
