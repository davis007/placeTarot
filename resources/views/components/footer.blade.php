<footer class="mystical-bg text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Site Info -->
            <div>
                <h3 class="text-xl font-bold mb-4 flex items-center">
                    <img src="{{ asset('images/logo.svg') }}" alt="Tarotique" class="h-10 w-auto mr-2" />
                </h3>
                <p class="text-gray-300 mb-4">
                    タロット講座の受講生が実践経験を積むためのプラットフォームです。
                    鑑定を受けたい方と鑑定の練習をしたい方をつなぎます。
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-secondary">クイックリンク</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-secondary flex items-center">
                            <span class="material-icons mr-1 text-sm">home</span>
                            ホーム
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-secondary flex items-center">
                                <span class="material-icons mr-1 text-sm">dashboard</span>
                                ダッシュボード
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('consultations.index') }}" class="text-gray-300 hover:text-secondary flex items-center">
                                <span class="material-icons mr-1 text-sm">question_answer</span>
                                鑑定一覧
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('points.index') }}" class="text-gray-300 hover:text-secondary flex items-center">
                                <span class="material-icons mr-1 text-sm">stars</span>
                                ポイント
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-secondary flex items-center">
                                <span class="material-icons mr-1 text-sm">login</span>
                                ログイン
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-gray-300 hover:text-secondary flex items-center">
                                <span class="material-icons mr-1 text-sm">person_add</span>
                                新規登録
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact & Legal -->
            <div>
                <h3 class="text-lg font-bold mb-4 text-secondary">お問い合わせ・規約</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-gray-300 hover:text-secondary flex items-center">
                            <span class="material-icons mr-1 text-sm">email</span>
                            お問い合わせ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-secondary flex items-center">
                            <span class="material-icons mr-1 text-sm">gavel</span>
                            利用規約
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-300 hover:text-secondary flex items-center">
                            <span class="material-icons mr-1 text-sm">security</span>
                            プライバシーポリシー
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-opacity-20 border-secondary text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Tarotique. All rights reserved.</p>
        </div>
    </div>
</footer>
