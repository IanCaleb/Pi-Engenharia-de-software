<header class="w-full border-b border-[#C1C1C1] bg-white relative">

    <div class="max-w-7xl mx-auto px-4 md:px-8">

        <div class="h-20 flex items-center justify-between gap-6">

            <!-- Logo -->
            <a href="#" class="shrink-0">
                <img
                    src="{{ asset('images/Logo.svg') }}"
                    alt="Logo"
                    class="w-36 sm:w-40 md:w-44"
                >
            </a>

            <!-- Navegação Desktop -->
            <nav class="hidden lg:flex flex-1 justify-center">
                <ul class="flex items-center gap-8 text-lg font-bold text-[#1E1E1E]">

                    <li>
                        <a href="#" class="hover:text-[#517517] transition">
                            Início
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-[#517517] transition">
                            Como Funciona
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-[#517517] transition">
                            Sobre
                        </a>
                    </li>

                </ul>
            </nav>

            <!-- Ações Desktop -->
            <div class="hidden lg:flex items-center gap-3">
                @if (Route::has('login'))
                        @auth
                            <a
                                href="{{ url('/dashboard') }}"
                                class="bg-[#517517] text-white font-bold rounded-xl px-5 py-2.5 hover:bg-[#456614] transition"
                            >
                                Dashboard
                            </a>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="rounded-xl font-bold border border-[#C1C1C1] px-5 py-2.5 hover:bg-gray-50 transition"
                            >
                                Entrar
                            </a>

                            @if (Route::has('register'))
                                <a
                                    href="{{ route('register') }}"
                                    class="bg-[#517517] text-white font-bold rounded-xl px-5 py-2.5 hover:bg-[#456614] transition"
                                >
                                    Cadastre sua conta
                                </a>
                            @endif
                        @endauth
                @endif
            </div>

            <!-- Botão Mobile -->
            <button
                onclick="document.getElementById('mobileMenu').classList.remove('hidden')"
                class="lg:hidden flex items-center justify-center w-11 h-11 rounded-xl border border-[#C1C1C1]"
            >
                <span class="text-2xl leading-none">☰</span>
            </button>

        </div>

    </div>

    <!-- Overlay Mobile -->
    <div
        id="mobileMenu"
        class="hidden fixed inset-0 bg-black/50 z-50"
    >

        <!-- Painel -->
        <div class="absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white shadow-2xl p-6 flex flex-col">

            <!-- Topo -->
            <div class="flex items-center justify-between mb-8">

                <img
                    src="{{ asset('images/Logo.svg') }}"
                    alt="Logo"
                    class="w-32"
                >

                <button
                    onclick="document.getElementById('mobileMenu').classList.add('hidden')"
                    class="text-3xl leading-none"
                >
                    ×
                </button>

            </div>

            <!-- Links -->
            <nav class="flex flex-col gap-5 text-lg font-bold text-[#1E1E1E]">

                <a href="#" class="hover:text-[#517517] transition">
                    Início
                </a>

                <a href="#" class="hover:text-[#517517] transition">
                    Como Funciona
                </a>

                <a href="#" class="hover:text-[#517517] transition">
                    Sobre
                </a>

            </nav>

            <!-- Botões -->
            <div class="mt-auto flex flex-col gap-3 pt-8">

                <a
                    href="#"
                    class="rounded-xl font-bold border border-[#C1C1C1] px-5 py-3 text-center"
                >
                    Entrar
                </a>

                <a
                    href="#"
                    class="bg-[#517517] text-white font-bold rounded-xl px-5 py-3 text-center"
                >
                    Cadastre sua conta
                </a>

            </div>

        </div>

    </div>

</header>