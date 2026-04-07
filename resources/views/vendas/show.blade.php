@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-4 md:p-6 space-y-6">

    <a href="{{ route('vendas.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium transition-colors hover:bg-slate-200 h-10 px-4 py-2 text-slate-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
            <path d="m12 19-7-7 7-7"></path>
            <path d="M19 12H5"></path>
        </svg>
        Voltar
    </a>

    <div class="rounded-lg border border-slate-200 bg-white text-slate-900 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/50">
            <h3 class="font-bold tracking-tight text-lg text-slate-800">Resumo da Venda</h3>
        </div>

        <div class="p-6 space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Cliente</p>
                    <p class="text-lg font-semibold text-slate-900">{{ $venda->cliente_nome }}</p>
                    @if($venda->cpf)
                    <p class="text-xs text-slate-400 mt-0.5">{{ $venda->cpf }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Data</p>
                    <p class="text-sm font-medium">{{ $venda->data_venda->format('d/m/Y') }}</p>
                </div>
            </div>


            <div class="border rounded-xl overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-slate-50 text-slate-600 border-b">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Peça / Serviço</th>
                            <th class="px-4 py-3 text-right font-semibold">Preço Unit.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @php
                        $nomesItens = explode(', ', $venda->item);
                        $precosItens = $venda->item_prices ?? [];
                        @endphp

                        @foreach($nomesItens as $index => $nome)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $nome }}</td>
                            <td class="px-4 py-3 text-right font-medium text-slate-900">
                                R$ {{ number_format($precosItens[$index] ?? 0, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-violet-50/50 border-t border-violet-100">
                        <tr class="text-violet-900 font-bold">
                            <td class="px-4 py-3 text-sm">Total da Venda</td>
                            <td class="px-4 py-3 text-right text-lg">
                                R$ {{ number_format($venda->valor_total, 2, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if(!$venda->is_flexivel)
            <div class="flex items-center gap-2 text-slate-500 text-xs bg-slate-100 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <line x1="2" x2="22" y1="10" y2="10" />
                </svg>
                @php
                $valorParcela = $venda->quantidade_parcelas > 0 ? $venda->valor_total / $venda->quantidade_parcelas : $venda->valor_total;
                @endphp
                Pagamento parcelado em <strong>{{ $venda->quantidade_parcelas }}x</strong> de R$ {{ number_format($valorParcela, 2, ',', '.') }}
            </div>
            @endif
        </div>
    </div>

    @if($venda->is_flexivel)
    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex items-center justify-between shadow-sm">
        <div>
            <p class="text-indigo-900 font-bold text-sm">Saldo Devedor Atual</p>
            <p class="text-2xl font-black text-indigo-700">
                R$ {{ number_format($venda->parcelas()->where('pago', false)->sum('valor'), 2, ',', '.') }}
            </p>
        </div>
        <button onclick="abrirModalAbatimento()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition-all active:scale-95">
            Abater Valor
        </button>
    </div>
    @endif

    <div class="rounded-lg border border-slate-200 bg-white text-slate-900 shadow-sm">
        <div class="p-6 border-b border-slate-50 flex items-center justify-between">
            <h3 class="font-semibold tracking-tight text-lg">
                {{ $venda->is_flexivel ? 'Histórico de Saldo' : 'Parcelas' }}
            </h3>
        </div>
        <div class="p-6">
            <ul class="space-y-4">
                @foreach($venda->parcelas as $parcela)
                <li class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 gap-2">
                    <div class="flex items-center gap-3 min-w-0">
                        @if(!$parcela->pago)
                        <button class="btn-pagar-parcela shrink-0 transition-colors {{ $parcela->pago ? 'text-emerald-500' : 'text-slate-300 hover:text-emerald-500' }}"
                            data-id="{{ $parcela->id }}"
                            data-pago="{{ $parcela->pago ? 'true' : 'false' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                @if($parcela->pago)
                                <path d="m9 12 2 2 4-4" class="check-mark"></path>
                                @endif
                            </svg>
                        </button>
                        @else
                        <div class="text-emerald-500 shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>
                        </div>
                        @endif

                        <div class="min-w-0">
                            <p class="font-medium text-sm text-slate-800">
                                {{ $venda->is_flexivel ? 'Saldo em Aberto' : 'Parcela ' . $parcela->numero_parcela }}
                            </p>
                            <div class="flex items-center gap-1">
                                <p id="data-text-{{ $parcela->id }}" class="text-xs text-slate-500">
                                    {{ $parcela->data_vencimento ? $parcela->data_vencimento->format('d/m/Y') : 'Sem vencimento fixo' }}
                                </p>

                                @if(!$venda->is_flexivel && $parcela->data_vencimento)
                                <button type="button" class="btn-abrir-modal-editar text-slate-400 hover:text-violet-600 transition-colors"
                                    data-id="{{ $parcela->id }}"
                                    data-data="{{ $parcela->data_vencimento->format('Y-m-d') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-1">
                        <span class="text-sm font-bold text-slate-900">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</span>
                        @if($parcela->pago)
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold text-emerald-700 uppercase">Pago</span>
                        @elseif($parcela->data_vencimento && $parcela->data_vencimento->isPast())
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-[10px] font-bold text-red-700 uppercase">Atrasado</span>
                        @else
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-[10px] font-bold text-slate-600 uppercase">Pendente</span>
                        @endif
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<div id="modalEditarData" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-bold text-slate-900">Alterar Vencimento</h3>
            <p class="text-xs text-slate-500">Escolha uma nova data para esta parcela.</p>
        </div>
        <div class="p-6">
            <input type="hidden" id="editParcelaId">
            <input type="date" id="editNovaData" class="w-full rounded-lg border-slate-200 focus:border-violet-500 focus:ring-violet-500">
        </div>
        <div class="p-6 bg-slate-50 flex justify-end gap-3">
            <button type="button" onclick="fecharModal()" class="text-sm font-medium text-slate-600 hover:text-slate-800">Cancelar</button>
            <button type="button" onclick="salvarNovaData()" class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                Salvar Alteração
            </button>
        </div>
    </div>
</div>

<div id="modalAbatimento" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-xl border border-slate-200 w-full max-w-sm overflow-hidden">
        <form action="{{ route('vendas.abater', $venda->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="p-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Abater Valor</h3>
                <p class="text-xs text-slate-500">Informe o valor pago para reduzir o saldo devedor.</p>
            </div>

            <div class="p-6">
                <label class="block text-sm font-medium text-slate-700 mb-1">Valor do Pagamento</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-slate-400">R$</span>
                    <input type="number" name="valor_abatido" step="0.01" required autofocus
                        class="w-full pl-10 rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="0,00">
                </div>
            </div>

            <div class="p-6 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="fecharModalAbatimento()" class="text-sm font-medium text-slate-600 hover:text-slate-800">Cancelar</button>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors shadow-md">
                    Confirmar Abatimento
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.btn-pagar-parcela').forEach(button => {
        button.addEventListener('click', async function() {
            const parcelaId = this.dataset.id;
            try {
                const response = await fetch(`/parcelas/${parcelaId}/pagar`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();
                if (data.success) {
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-emerald-500">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>`;
                    this.classList.replace('text-slate-300', 'text-emerald-500');
                    if ("{{ $venda->is_flexivel }}") window.location.reload();
                }
            } catch (error) {
                console.error('Erro ao processar pagamento:', error);
            }
        });
    });

    const modalEditar = document.getElementById('modalEditarData');
    const inputId = document.getElementById('editParcelaId');
    const inputData = document.getElementById('editNovaData');

    document.querySelectorAll('.btn-abrir-modal-editar').forEach(btn => {
        btn.addEventListener('click', function() {
            inputId.value = this.dataset.id;
            inputData.value = this.dataset.data;
            modalEditar.classList.remove('hidden');
        });
    });

    function fecharModal() {
        modalEditar.classList.add('hidden');
    }

    async function salvarNovaData() {
        const id = inputId.value;
        const novaDataValue = inputData.value;
        try {
            const response = await fetch(`/parcelas/${id}/update-date`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    data_vencimento: novaDataValue
                })
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById(`data-text-${id}`).innerText = data.nova_data;
                const btn = document.querySelector(`.btn-abrir-modal-editar[data-id="${id}"]`);
                if (btn) btn.dataset.data = novaDataValue;
                fecharModal();
            }
        } catch (error) {
            console.error('Erro ao atualizar data:', error);
        }
    }

    function abrirModalAbatimento() {
        document.getElementById('modalAbatimento').classList.remove('hidden');
    }

    function fecharModalAbatimento() {
        document.getElementById('modalAbatimento').classList.add('hidden');
    }
</script>
@endsection