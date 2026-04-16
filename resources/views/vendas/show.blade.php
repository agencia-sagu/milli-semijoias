@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/vendas.css') }}">

<div class="sv-page">

    <div class="sv-header">
        <a href="{{ route('vendas.index') }}" class="sv-back-btn" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
        </a>
        <div class="sv-title-block">
            <h1>Detalhes da Venda</h1>
            <p>{{ $venda->cliente_nome }} · {{ $venda->data_venda->format('d/m/Y') }}</p>
        </div>
    </div>

    <div class="sv-card">
        <div class="sv-card-header">
            <div class="sv-card-title">
                <div class="sv-card-title-dot dot-pink"></div>Resumo da Venda
            </div>
            <button onclick="abrirModalNovosItens()" class="sv-abater-btn sv-btn-add-item">+ Itens</button>
        </div>

        <div class="sv-card-body" style="display:flex;flex-direction:column;gap:1.1rem;">

            <div class="sv-client-row">
                <div>
                    <p class="sv-client-label">Cliente</p>
                    <p class="sv-client-name">{{ $venda->cliente_nome }}</p>
                    @if($venda->cpf)
                    <p class="sv-client-cpf">{{ $venda->cpf }}</p>
                    @endif
                </div>
                <div class="sv-date-block">
                    <p class="sv-client-label">Data da venda</p>
                    <p class="sv-date-value">{{ $venda->data_venda->format('d/m/Y') }}</p>
                </div>
            </div>

            @php
            $nomesItens = explode(', ', $venda->item);
            $precosItens = $venda->item_prices ?? [];
            @endphp
            <table class="sv-items-table">
                <thead>
                    <tr>
                        <th>Peça / Serviço</th>
                        <th>Preço Unit.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nomesItens as $index => $nome)
                    <tr>
                        <td>{{ $nome }}</td>
                        <td>R$ {{ number_format($precosItens[$index] ?? 0, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>Total da Venda</td>
                        <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>

            @if(!$venda->is_flexivel)
            @php
            $valorParcela = $venda->quantidade_parcelas > 0
            ? $venda->valor_total / $venda->quantidade_parcelas
            : $venda->valor_total;
            @endphp
            <div class="sv-parcel-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;color:#d1a3bf">
                    <rect width="20" height="14" x="2" y="5" rx="2" />
                    <line x1="2" x2="22" y1="10" y2="10" />
                </svg>
                Parcelado em <strong>{{ $venda->quantidade_parcelas }}×</strong> de
                <strong>R$ {{ number_format($valorParcela, 2, ',', '.') }}</strong>
            </div>
            @endif
        </div>
    </div>

    @if($venda->is_flexivel)
    <div class="sv-saldo-card">
        <div>
            <p class="sv-saldo-label">Saldo Devedor Atual</p>
            <p class="sv-saldo-value">
                R$ {{ number_format($venda->parcelas()->where('pago', false)->sum('valor'), 2, ',', '.') }}
            </p>
        </div>
        <button onclick="abrirModalAbatimento()" class="sv-abater-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Abater Valor
        </button>
    </div>
    @endif

    <div class="sv-card">
        <div class="sv-card-header">
            <div class="sv-card-title">
                <div class="sv-card-title-dot {{ $venda->is_flexivel ? 'dot-indigo' : 'dot-violet' }}"></div>
                {{ $venda->is_flexivel ? 'Histórico de Saldo' : 'Parcelas' }}
            </div>
        </div>
        <div class="sv-card-body">
            <ul style="list-style:none;margin:0;padding:0;">
                @foreach($venda->parcelas as $parcela)
                @php
                $isPago = $parcela->pago;
                $isAtrasado= !$isPago && $parcela->data_vencimento && $parcela->data_vencimento->isPast();
                $badgeClass= $isPago ? 'badge-pago' : ($isAtrasado ? 'badge-atrasado' : 'badge-pendente');
                $badgeLabel= $isPago ? 'Pago' : ($isAtrasado ? 'Atrasado' : 'Pendente');
                @endphp
                <li class="sv-parcela-item">
                    <div class="sv-parcela-left">
                        @if($isPago)
                        <div class="sv-check-done" title="Pago">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </div>
                        @else
                        <button class="sv-check-btn btn-pagar-parcela"
                            data-id="{{ $parcela->id }}"
                            data-pago="false"
                            title="Marcar como pago">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m9 12 2 2 4-4" />
                            </svg>
                        </button>
                        @endif

                        <div>
                            <p class="sv-parcela-num">
                                {{ $venda->is_flexivel ? 'Saldo em Aberto' : 'Parcela ' . $parcela->numero_parcela }}
                            </p>
                            <div class="sv-parcela-date">
                                <span id="data-text-{{ $parcela->id }}">
                                    {{ $parcela->data_vencimento
                                        ? $parcela->data_vencimento->format('d/m/Y')
                                        : 'Sem vencimento fixo' }}
                                </span>
                                @if(!$venda->is_flexivel && $parcela->data_vencimento)
                                <button type="button"
                                    class="sv-edit-date-btn btn-abrir-modal-editar"
                                    data-id="{{ $parcela->id }}"
                                    data-data="{{ $parcela->data_vencimento->format('Y-m-d') }}"
                                    title="Alterar data">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2.5"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                        <path d="m15 5 4 4" />
                                    </svg>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="sv-parcela-right">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <span class="sv-parcela-valor">R$ {{ number_format($parcela->valor, 2, ',', '.') }}</span>
                            @if(!$isPago)
                            <button type="button" class="sv-edit-date-btn btn-abrir-modal-valor"
                                data-id="{{ $parcela->id }}"
                                data-valor="{{ $parcela->valor }}"
                                title="Editar valor">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                    <path d="m15 5 4 4" />
                                </svg>
                            </button>
                            @endif
                        </div>
                        <span class="sv-badge {{ $badgeClass }}">
                            <span class="sv-badge-dot"></span>{{ $badgeLabel }}
                        </span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

</div>

<div id="modalEditarData" class="sv-modal-overlay">
    <div class="sv-modal">
        <div class="sv-modal-head">
            <h3>Alterar Vencimento</h3>
            <p>Escolha uma nova data para esta parcela</p>
        </div>
        <div class="sv-modal-body">
            <input type="hidden" id="editParcelaId">
            <label class="sv-modal-label" for="editNovaData">Nova data</label>
            <input type="date" id="editNovaData" class="sv-modal-input">
        </div>
        <div class="sv-modal-foot">
            <button type="button" onclick="fecharModal()" class="sv-modal-cancel">Cancelar</button>
            <button type="button" onclick="salvarNovaData()" class="sv-modal-confirm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 6 9 17l-5-5" />
                </svg>
                Salvar
            </button>
        </div>
    </div>
</div>

<div id="modalAbatimento" class="sv-modal-overlay">
    <div class="sv-modal">
        <form action="{{ route('vendas.abater', $venda->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="sv-modal-head">
                <h3>Abater Valor</h3>
                <p>Informe o valor pago para reduzir o saldo devedor</p>
            </div>
            <div class="sv-modal-body">
                <label class="sv-modal-label" for="valor_abatido">Valor do pagamento</label>
                <div class="sv-modal-input-wrap">
                    <span class="sv-modal-money-prefix">R$</span>
                    <input type="number" name="valor_abatido" id="valor_abatido"
                        step="0.01" required autofocus
                        class="sv-modal-input sv-modal-input-money"
                        placeholder="0,00">
                </div>
            </div>
            <div class="sv-modal-foot">
                <button type="button" onclick="fecharModalAbatimento()" class="sv-modal-cancel">Cancelar</button>
                <button type="submit" class="sv-modal-confirm violet">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5" />
                    </svg>
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditarValor" class="sv-modal-overlay">
    <div class="sv-modal">
        <div class="sv-modal-head">
            <h3>Ajustar Valor</h3>
            <p>O saldo das próximas parcelas será recalculado automaticamente.</p>
        </div>
        <div class="sv-modal-body">
            <input type="hidden" id="editValorParcelaId">
            <label class="sv-modal-label">Novo valor desta parcela</label>
            <div class="sv-modal-input-wrap">
                <span class="sv-modal-money-prefix">R$</span>
                <input type="number" id="inputNovoValor" step="0.01" class="sv-modal-input sv-modal-input-money">
            </div>
        </div>
        <div class="sv-modal-foot">
            <button type="button" onclick="fecharModalValor()" class="sv-modal-cancel">Cancelar</button>
            <button type="button" onclick="salvarNovoValor()" class="sv-modal-confirm">Ajustar e Recalcular</button>
        </div>
    </div>
</div>

<div id="modalNovosItens" class="sv-modal-overlay">
    <div class="sv-modal">
        <form action="{{ route('vendas.adicionar-itens', $venda->id) }}" method="POST">
            @csrf
            <div class="sv-modal-head">
                <h3>Adicionar Itens</h3>
            </div>
            <div class="sv-modal-body" id="containerNovosItens">
                <div style="display:flex; gap:10px; margin-bottom:10px;">
                    <input type="text" name="novos_items[]" class="sv-modal-input" placeholder="Item" required>
                    <input type="number" name="novos_item_prices[]" step="0.01" class="sv-modal-input" placeholder="R$" style="width:100px;" required>
                </div>
            </div>
            <div style="padding:0 1.5rem 1rem;"><button type="button" onclick="maisUmItem()" style="background:none; border:none; color:#be185d; font-size:0.8rem; cursor:pointer;">+ Linha</button></div>
            <div class="sv-modal-foot">
                <button type="button" onclick="fecharModal('modalNovosItens')" style="background:none; border:none; color:#9ca3af;">Cancelar</button>
                <button type="submit" class="sv-abater-btn">Confirmar</button>
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
                    const done = document.createElement('div');
                    done.className = 'sv-check-done';
                    done.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m9 12 2 2 4-4"/></svg>`;
                    this.replaceWith(done);

                    const li = done.closest('.sv-parcela-item');
                    const badge = li.querySelector('.sv-badge');
                    if (badge) {
                        badge.className = 'sv-badge badge-pago';
                        badge.innerHTML = `<span class="sv-badge-dot" style="background:#059669"></span>Pago`;
                    }

                    if ("{{ $venda->is_flexivel }}") window.location.reload();
                }
            } catch (error) {
                console.error(error);
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
            modalEditar.classList.add('open');
        });
    });

    function fecharModal() {
        modalEditar.classList.remove('open');
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
            console.error(error);
        }
    }

    function abrirModalAbatimento() {
        document.getElementById('modalAbatimento').classList.add('open');
    }

    function fecharModalAbatimento() {
        document.getElementById('modalAbatimento').classList.remove('open');
    }

    [
        modalEditar,
        document.getElementById('modalAbatimento'),
        document.getElementById('modalEditarValor')
    ].forEach(modal => {
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('open');
                }
            });
        }
    });

    document.querySelectorAll('.btn-abrir-modal-valor').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editValorParcelaId').value = this.dataset.id;
            document.getElementById('inputNovoValor').value = this.dataset.valor;
            document.getElementById('modalEditarValor').classList.add('open');
        });
    });

    function fecharModalValor() {
        document.getElementById('modalEditarValor').classList.remove('open');
    }

    async function salvarNovoValor() {
        const id = document.getElementById('editValorParcelaId').value;
        const novoValor = document.getElementById('inputNovoValor').value;

        try {
            const response = await fetch(`/parcelas/${id}/recalcular`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    valor: novoValor
                })
            });

            const data = await response.json();
            if (data.success) {
                // Como várias parcelas mudam, o melhor é recarregar a página
                window.location.reload();
            } else {
                alert(data.message || 'Erro ao recalcular');
            }
        } catch (error) {
            console.error(error);
        }
    }

    // Abre o modal de novos itens
    function abrirModalNovosItens() {
        document.getElementById('modalNovosItens').classList.add('open');
    }

    // Adiciona uma nova linha de Input dinamicamente
    function maisUmItem() {
        const row = document.createElement('div');
        row.style.display = 'flex';
        row.style.gap = '10px';
        row.style.marginBottom = '10px';
        row.innerHTML = `
        <input type="text" name="novos_items[]" class="sv-modal-input" placeholder="Item" required>
        <input type="number" name="novos_item_prices[]" step="0.01" class="sv-modal-input" placeholder="R$" style="width:100px;" required>
    `;
        document.getElementById('containerNovosItens').appendChild(row);
    }
</script>

@endsection