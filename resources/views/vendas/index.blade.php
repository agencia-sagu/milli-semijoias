@extends('layouts.app')

@section('content')

<div class="p-4 lg:p-8 max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Vendas</h1>
            <p class="text-slate-500 text-sm">Gerencie o fluxo de pagamentos e contratos.</p>
        </div>
        <a href="{{ route('vendas.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-violet-200 gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Nova Venda
        </a>
    </div>

    <div class="flex bg-slate-200/50 p-1 rounded-xl w-fit mb-6 overflow-x-auto no-scrollbar">
        @php $currentStatus = request('status'); @endphp
        <a href="{{ route('vendas.index') }}"
            class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all {{ !$currentStatus ? 'bg-white text-violet-400 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Todos
        </a>
        <a href="{{ route('vendas.index', ['status' => 'pendente']) }}"
            class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'pendente' ? 'bg-white text-violet-400 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Pendentes
        </a>
        <a href="{{ route('vendas.index', ['status' => 'atrasado']) }}"
            class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'atrasado' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Atrasados
        </a>
        <a href="{{ route('vendas.index', ['status' => 'pago']) }}"
            class="px-4 py-1.5 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'pago' ? 'bg-white text-emerald-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
            Pagos
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl text-sm font-semibold">
        ✓ {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('vendas.index') }}" class="mb-6">
        @if($currentStatus)
        <input type="hidden" name="status" value="{{ $currentStatus }}">
        @endif
        <div class="flex gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Buscar por cliente ou item..."
                    class="w-full pl-10 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-violet-300 focus:border-violet-400 shadow-sm transition-all">
                @if(request('q'))
                <a href="{{ route('vendas.index', array_filter(['status' => $currentStatus])) }}"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </a>
                @endif
            </div>

            <button type="submit"
                class="inline-flex items-center justify-center w-11 h-11 bg-violet-600 hover:bg-violet-700 text-white rounded-xl shadow-sm shadow-violet-200 transition-all flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-4 md:hidden">
        @foreach ($vendas as $venda)
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-bold text-slate-900">{{ $venda->cliente_nome }}</h3>
                    <p class="text-xs text-slate-500">{{ Str::limit($venda->item, 25) }}</p>
                </div>
                <span class="text-sm font-black text-slate-900">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
            </div>

            <div class="flex items-center justify-between mt-3">
                <div class="flex flex-col gap-1.5 flex-1 pr-4">
                    <span class="text-[10px] uppercase tracking-wider font-bold text-slate-400">Progresso</span>

                    @php
                    if($venda->is_flexivel) {
                    $pago = $venda->parcelas->where('pago', true)->sum('valor');
                    $percent = ($venda->valor_total > 0) ? ($pago / $venda->valor_total) * 100 : 0;
                    $label = number_format($percent, 0) . '% pago';
                    } else {
                    $pagoCount = $venda->parcelas->where('pago', true)->count();
                    $percent = ($venda->quantidade_parcelas > 0) ? ($pagoCount / $venda->quantidade_parcelas) * 100 : 0;
                    $label = "$pagoCount/{$venda->quantidade_parcelas} parcelas";
                    }
                    @endphp

                    <div class="flex items-center gap-2">
                        <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-violet-500 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="text-[11px] font-bold text-slate-700 whitespace-nowrap">{{ $label }}</span>
                    </div>
                </div>

                <div>
                    @if($venda->is_flexivel && $venda->status_geral !== 'pago')
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-indigo-100 text-indigo-600">
                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                        FLEXÍVEL
                    </span>
                    @else
                    @php $status = $venda->status_geral; @endphp
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                    {{ $status === 'atrasado' ? 'bg-red-100 text-red-600' : ($status === 'pago' ? 'bg-emerald-100 text-emerald-600' : 'bg-violet-100 text-violet-400') }}">
                        {{ $status }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end gap-1 mt-4 pt-3 border-t border-slate-100">
                <a href="{{ route('vendas.show', $venda->id) }}"
                    class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-violet-500 hover:bg-violet-50 rounded-xl transition-all" title="Visualizar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                </a>

                <a href="{{ route('vendas.edit', $venda->id) }}"
                    class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Editar">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                </a>

                <form action="{{ route('vendas.excluir', $venda->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Excluir">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                            <line x1="10" x2="10" y1="11" y2="17" />
                            <line x1="14" x2="14" y1="11" y2="17" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="hidden md:block bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-left">
                    <th class="px-3 lg:px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Cliente / Item</th>
                    <th class="px-3 lg:px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Valor Total</th>
                    <th class="px-3 lg:px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Parcelas</th>
                    <th class="px-3 lg:px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                    <th class="px-3 lg:px-6 py-4 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($vendas as $venda)
                <tr class="group hover:bg-slate-50/80 transition-all">
                    <td class="px-3 lg:px-6 py-4">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-900 group-hover:text-violet-400 transition-colors">{{ $venda->cliente_nome }}</span>
                            <span class="text-xs text-slate-400">{{ Str::limit($venda->item, 40) }}</span>
                        </div>
                    </td>
                    <td class="px-3 lg:px-6 py-4">
                        <span class="text-sm font-bold text-slate-900 tabular-nums">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
                    </td>
                    <td class="px-3 lg:px-6 py-4">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between w-24">
                                @if($venda->is_flexivel)
                                @php
                                $pago = $venda->parcelas->where('pago', true)->sum('valor');
                                $percent = ($venda->valor_total > 0) ? ($pago / $venda->valor_total) * 100 : 0;
                                @endphp
                                <span class="text-[11px] font-bold text-slate-600">
                                    {{ number_format($percent, 0) }}% pago
                                </span>
                                @else
                                @php $percent = ($venda->parcelas->where('pago', true)->count() / $venda->quantidade_parcelas) * 100; @endphp
                                <span class="text-[11px] font-bold text-slate-600">
                                    {{ $venda->parcelas->where('pago', true)->count() }}/{{ $venda->quantidade_parcelas }}
                                </span>
                                @endif
                            </div>
                            <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-violet-500 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 lg:px-6 py-4">
                        @if($venda->is_flexivel && $venda->status_geral !== 'pago')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                            FLEXÍVEL
                        </span>
                        @else
                        @php $status = $venda->status_geral; @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wider
                {{ $status === 'atrasado' ? 'bg-red-50 text-red-600' : ($status === 'pago' ? 'bg-emerald-50 text-emerald-600' : 'bg-violet-50 text-violet-400') }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $status === 'atrasado' ? 'bg-red-600' : ($status === 'pago' ? 'bg-emerald-600' : 'bg-violet-600') }}"></span>
                            {{ $status }}
                        </span>
                        @endif
                    </td>
                    <td class="px-3 lg:px-6 py-4 text-right space-x-1">
                        <a href="{{ route('vendas.show', $venda->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-violet-400 hover:bg-violet-50 rounded-xl transition-all" title="Visualizar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                        </a>

                        <a href="{{ route('vendas.edit', $venda->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all" title="Editar">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </a>

                        <form action="{{ route('vendas.excluir', $venda->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta venda?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Excluir">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                    <line x1="10" x2="10" y1="11" y2="17" />
                                    <line x1="14" x2="14" y1="11" y2="17" />
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6 px-4 font-sans ">
        {{ $vendas->links() }}
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection