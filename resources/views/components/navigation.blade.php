<nav class="bg-primary text-white material-shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold flex items-center">
                        <img src="{{ asset('images/logo-compact.svg') }}" alt="Tarotique" class="h-8 w-auto mr-2" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ml-10 sm:flex">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                            <span class="material-icons mr-1">dashboard</span>
                            ダッシュボード
                        </a>

                        <a href="{{ route('consultations.index') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                            <span class="material-icons mr-1">question_answer</span>
                            鑑定一覧
                        </a>

                        @if(auth()->user()->isClient())
                            <a href="{{ route('practitioners.index') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                                <span class="material-icons mr-1">people</span>
                                鑑定師を探す
                            </a>
                        @endif

                        <a href="{{ route('points.index') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                            <span class="material-icons mr-1">stars</span>
                            ポイント
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                                <span class="material-icons mr-1">admin_panel_settings</span>
                                管理画面
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                            <span class="material-icons mr-1">login</span>
                            ログイン
                        </a>

                        <a href="{{ route('register') }}" class="inline-flex items-center px-1 pt-1 text-white hover:text-secondary">
                            <span class="material-icons mr-1">person_add</span>
                            新規登録
                        </a>
                    @endauth
                </div>
            </div>

            <!-- User Menu -->
            @auth
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <div x-data="{ open: false }" class="ml-3 relative">
                        <div>
                            <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary focus:ring-secondary">
                                <span class="material-icons text-secondary">account_circle</span>
                                <span class="ml-1">{{ Auth::user()->name }}</span>
                                <span class="material-icons">arrow_drop_down</span>
                            </button>
                        </div>

                        <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-background ring-1 ring-secondary ring-opacity-50 focus:outline-none z-50" style="display: none;">
                            <a href="{{ route('profile.show', Auth::user()->id) }}" class="block px-4 py-2 text-sm text-text hover:bg-secondary hover:text-white">
                                <span class="material-icons mr-1 text-sm">person</span>
                                プロフィール
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-text hover:bg-accent1 hover:text-white">
                                    <span class="material-icons mr-1 text-sm">logout</span>
                                    ログアウト
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button x-data="{ open: false }" @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-secondary focus:outline-none">
                    <span class="material-icons">menu</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-data="{ open: false }" :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <a href="{{ route('dashboard') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">dashboard</span>
                    ダッシュボード
                </a>

                <a href="{{ route('consultations.index') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">question_answer</span>
                    鑑定一覧
                </a>

                @if(auth()->user()->isClient())
                    <a href="{{ route('practitioners.index') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                        <span class="material-icons mr-1">people</span>
                        鑑定師を探す
                    </a>
                @endif

                <a href="{{ route('points.index') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">stars</span>
                    ポイント
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.users.index') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                        <span class="material-icons mr-1">admin_panel_settings</span>
                        管理画面
                    </a>
                @endif

                <a href="{{ route('profile.show', Auth::user()->id) }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">person</span>
                    プロフィール
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-white hover:bg-accent1 hover:text-white">
                        <span class="material-icons mr-1">logout</span>
                        ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">login</span>
                    ログイン
                </a>

                <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-white hover:bg-dark hover:text-secondary">
                    <span class="material-icons mr-1">person_add</span>
                    新規登録
                </a>
            @endauth
        </div>
    </div>
</nav>
