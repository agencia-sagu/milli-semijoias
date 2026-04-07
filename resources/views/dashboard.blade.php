@extends('layouts.app')

@section('content')
<div class="p-4 lg:p-8">
    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="text-slate-600 mt-1">Resumo das vendas e pagamentos</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white rounded-lg p-6 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Vendas Hoje</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">R$ {{ number_format($valorVendasHoje, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $vendasHoje }} vendas</p>
                    </div>
                    <div class="bg-blue-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-violet-400">
                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                            <polyline points="16 7 22 7 22 13"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Pendente</p>
                        <p class="text-2xl font-bold text-amber-600 mt-1">R$ {{ number_format($valorPendente, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $parcelasPendentes }} parcelas a receber
                        </p>
                    </div>
                    <div class="bg-amber-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-amber-600">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Atrasado</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">R$ {{ number_format($valorAtrasado, 2, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 mt-1">
                            {{ $pagamentoAtrasado }} pagamentos atrasados
                        </p>
                    </div>
                    <div class="bg-red-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-red-600">
                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                            <path d="M12 9v4"></path>
                            <path d="M12 17h.01"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-6 border border-slate-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600">Vence Hoje</p>
                        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $venceHoje }}</p>
                        <p class="text-xs text-slate-500 mt-1">pagamentos</p>
                    </div>
                    <div class="bg-purple-50 p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 text-purple-600">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                            <path d="m9 11 3 3L22 4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-slate-200">
            <div class="p-6 border-b border-slate-200">
                <h2 class="font-semibold text-slate-900">Notificações</h2>
            </div>
            <div class="divide-y divide-slate-200">

                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-red-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-red-600">
                                <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                                <path d="M12 9v4"></path>
                                <path d="M12 17h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-900">Pagamentos atrasados</p>
                            <p class="text-sm text-slate-600 mt-1">{{ $pagamentoAtrasado }} pagamento(s) em atraso</p>
                            <div class="mt-4 space-y-3">
                                @foreach ($atrasado as $venda)
                                @foreach ($venda->parcelas as $parcela) {{-- Mostra cada parcela atrasada do cliente --}}
                                <div class="flex items-center justify-between text-sm bg-slate-50 p-2 rounded border border-slate-100">
                                    <div class="flex flex-col">
                                        <a class="text-violet-400 hover:underline font-medium" href="{{ route('vendas.show', $venda->id) }}">
                                            {{ $venda->cliente_nome }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 uppercase">Venceu em {{ $parcela->data_vencimento->format('d/m/Y') }}</span>
                                    </div>
                                    <span class="font-bold text-red-600">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</span>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="bg-amber-100 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-amber-600">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-pink-500">Vencendo em breve</p>
                            <p class="text-sm text-slate-600 mt-1">
                                {{ $vencendoEmBreve->count() }} pagamento(s) vencem nos próximos 7 dias
                            </p>

                            <div class="mt-4 space-y-2">
                                @forelse ($vencendoEmBreve as $parcela)
                                @php
                                $diasRestantes = now()->startOfDay()->diffInDays($parcela->data_vencimento);
                                @endphp
                                <div class="flex items-center justify-between text-sm bg-slate-50 p-2 rounded border border-slate-100">
                                    <a class="text-pink-400 hover:underline font-medium" href="{{ route('vendas.show', $parcela->venda_id) }}">
                                        {{ $parcela->venda->cliente_nome }}
                                    </a>
                                    <div class="flex items-center gap-3">
                                        <span class="text-slate-500">
                                            {{ $diasRestantes == 1 ? 'Amanhã' : "em $diasRestantes dias" }}
                                        </span>
                                        <span class="font-bold text-slate-900">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                @empty
                                <p class="text-xs text-slate-400 italic">Nenhum pagamento previsto para os próximos dias.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection