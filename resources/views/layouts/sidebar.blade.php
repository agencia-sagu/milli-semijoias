<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed top-0 left-0 z-40 w-64 h-full transition-transform duration-300 bg-white border-r border-slate-200 lg:translate-x-0">

    <div class="p-6 flex items-center justify-between border-b border-slate-50 mb-4">
        <div class="flex items-center gap-2">
            <span class="text-xl font-bold text-slate-900 tracking-tight">Milli</span>
            <span class="text-xl font-bold text-pink-600">Semijóias</span>
        </div>

        <button @click="sidebarOpen = false" class="lg:hidden p-2 text-slate-400 hover:text-red-500 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" class="w-6 h-6">
                <path d="M18 6L6 18M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <nav class="px-4 space-y-1">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 transition-colors rounded-lg {{ request()->is('/') ? 'bg-pink-50 text-pink-400' : 'text-slate-600 hover:bg-slate-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="{{ route('vendas.create') }}"
            class="flex items-center gap-3 px-4 py-3 transition-colors rounded-lg {{ request()->routeIs('vendas.create') ? 'bg-pink-50 text-pink-400' : 'text-slate-600 hover:bg-slate-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path>
                <path d="M3 6h18"></path>
                <path d="M16 10a4 4 0 0 1-8 0"></path>
            </svg>
            <span class="font-medium">Nova Venda</span>
        </a>

        <a href="{{ route('vendas.index') }}"
            class="flex items-center gap-3 px-4 py-3 transition-colors rounded-lg {{ request()->routeIs('vendas.index', 'vendas.show', 'vendas.edit') ? 'bg-pink-50 text-pink-400' : 'text-slate-600 hover:bg-slate-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M10 12h11"></path>
                <path d="M10 18h11"></path>
                <path d="M10 6h11"></path>
                <path d="M4 10h2"></path>
                <path d="M4 6h1v4"></path>
                <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
            </svg>
            <span class="font-medium">Vendas</span>
        </a>

        <a href="{{ route('aniversarios.index') }}"
            class="flex items-center gap-3 px-4 py-3 transition-colors rounded-lg {{ request()->routeIs('aniversarios.index') ? 'bg-pink-50 text-pink-400' : 'text-slate-600 hover:bg-slate-50' }}">

            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                <path d="M12 2v4" />
                <path d="M10 6h4" />
                <path d="M4 10h16" />
                <path d="M5 10v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8" />
                <path d="M8 14v2" />
                <path d="M12 14v2" />
                <path d="M16 14v2" />
            </svg>

            <span class="font-medium">Aniversários</span>
        </a>

    </nav>
</aside>