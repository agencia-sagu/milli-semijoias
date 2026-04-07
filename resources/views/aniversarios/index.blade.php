@extends('layouts.app')

@section('content')
{{-- O x-data precisa envolver tudo que vai usar o estado 'open' --}}
<div class="p-4 lg:p-8 max-w-7xl mx-auto" x-data="{ open: false }">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Aniversariantes</h1>
            <p class="text-slate-500 text-sm">Gestão de clientes e datas especiais da Lisy Modas.</p>
        </div>

        <button @click="open = true" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Cadastrar Cliente
        </button>
    </div>

    {{-- GRID PRINCIPAL --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- COLUNA: HOJE --}}
        <div class="lg:col-span-1 space-y-4">
            <h2 class="text-sm font-black uppercase tracking-widest text-indigo-600 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-ping"></span>
                Hoje ({{ now()->format('d/m') }})
            </h2>

            @forelse($aniversariantesHoje as $cliente)
            <div class="bg-gradient-to-br from-indigo-600 to-violet-700 p-6 rounded-2xl shadow-xl shadow-indigo-100 relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-white font-bold text-lg">{{ $cliente->nome }}</h3>
                    <p class="text-indigo-100 text-sm mb-4">Completando {{ $cliente->data_nascimento->age }} anos!</p>

                    {{-- Note: Removi o link de WhatsApp pois você informou que removeu o campo --}}
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 text-white rounded-xl text-xs font-black uppercase backdrop-blur-sm">
                        🎉 Dia de Festa!
                    </span>
                </div>
                <svg class="absolute -right-4 -bottom-4 text-white/10 w-24 h-24 rotate-12 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                </svg>
            </div>
            @empty
            <div class="bg-white border-2 border-dashed border-slate-200 p-8 rounded-2xl text-center">
                <p class="text-slate-400 text-sm">Nenhum aniversário hoje.</p>
            </div>
            @endforelse
        </div>

        {{-- COLUNA: PRÓXIMOS --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">Próximos do Mês</h2>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <table class="w-full border-collapse">
                    <tbody class="divide-y divide-slate-100">
                        @forelse($aniversariantesMes as $cliente)
                        <tr class="hover:bg-slate-50 transition-all group">
                            <td class="px-6 py-4">
                                <span class="font-bold text-slate-900">{{ $cliente->nome }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex flex-col items-center justify-center w-12 h-12 bg-slate-100 rounded-xl group-hover:bg-indigo-50 transition-colors">
                                    <span class="text-[10px] font-black uppercase text-slate-400 group-hover:text-indigo-600">Dia</span>
                                    <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600">{{ $cliente->data_nascimento->format('d') }}</span>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="px-6 py-8 text-center text-slate-400 text-sm">Sem mais aniversariantes este mês.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- LISTA GERAL DE CLIENTES --}}
    <div class="mt-12">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">Base Geral de Clientes</h2>
            <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-lg">
                {{ $todosClientes->count() }} cadastrados
            </span>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-left">
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-wider">Nome da Cliente</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-wider text-center">Data de Nascimento</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-wider text-center">Idade</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase text-slate-400 tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($todosClientes as $cliente)
                        <tr class="hover:bg-slate-50/80 transition-all">
                            <td class="px-6 py-4">
                                <span class="font-semibold text-slate-900">{{ $cliente->nome }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-slate-600">
                                    {{ $cliente->data_nascimento->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800">
                                    {{ $cliente->data_nascimento->age }} anos
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta cliente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <p class="text-slate-400 text-sm">Nenhuma cliente cadastrada na base.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- MODAL DE CADASTRO --}}
    <div x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-cloak>

        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden" @click.away="open = false">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                <h3 class="font-black text-slate-900 uppercase tracking-tight">Nova Cliente</h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('clientes.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-black uppercase text-slate-500 mb-1 ml-1">Nome Completo</label>
                    <input type="text" name="nome" required placeholder="Ex: Maria Oliveira"
                        class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all text-slate-900 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-black uppercase text-slate-500 mb-1 ml-1">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" required
                        class="w-full px-4 py-3 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all text-slate-900 font-medium">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Salvar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection