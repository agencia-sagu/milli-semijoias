@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    .sv-page * {
        box-sizing: border-box;
    }

    .sv-page {
        min-height: 100vh;
        background: #fdf6f9;
        background-image:
            radial-gradient(ellipse at 0% 0%, #fce7f3 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, #fdf2f8 0%, transparent 50%);
        font-family: 'DM Sans', sans-serif;
        padding: 1.5rem 1rem 3rem;
    }

    .sv-header {
        max-width: 640px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sv-back-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1.5px solid #fbc6d8;
        background: white;
        color: #be185d;
        flex-shrink: 0;
        text-decoration: none;
        transition: all 0.2s;
    }

    .sv-back-btn:hover {
        background: #fdf2f8;
        border-color: #ec4899;
        box-shadow: 0 4px 12px #ec489920;
        transform: translateX(-2px);
    }

    .sv-title-block h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.4rem, 4vw, 1.9rem);
        color: #1e1b2e;
        margin: 0;
        line-height: 1.2;
    }

    .sv-title-block p {
        font-size: 0.85rem;
        color: #9ca3af;
        margin: 0.2rem 0 0;
    }

    .sv-card {
        max-width: 640px;
        margin: 0 auto 1.25rem;
        background: white;
        border-radius: 22px;
        box-shadow: 0 1px 3px #00000008, 0 8px 32px #be185d0d, 0 0 0 1px #fce7f3;
        overflow: hidden;
        animation: fadeUp 0.3s ease both;
    }

    .sv-card-header {
        padding: 1.1rem 1.5rem;
        border-bottom: 1px solid #fce7f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .sv-card-title {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #9ca3af;
    }

    .sv-card-title-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .dot-pink {
        background: #ec4899;
    }

    .dot-violet {
        background: #8b5cf6;
    }

    .dot-emerald {
        background: #10b981;
    }

    .dot-indigo {
        background: #6366f1;
    }

    .sv-card-body {
        padding: 1.25rem 1.5rem;
    }

    .sv-client-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .sv-client-name {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1e1b2e;
        margin: 0 0 0.15rem;
    }

    .sv-client-cpf {
        font-size: 0.78rem;
        color: #b0a0aa;
        margin: 0;
    }

    .sv-client-label {
        font-size: 0.68rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #c9a0b8;
        margin: 0 0 0.2rem;
    }

    .sv-date-block {
        text-align: right;
    }

    .sv-date-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #374151;
    }

    .sv-items-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0.25rem;
    }

    .sv-items-table thead tr {
        border-bottom: 1px solid #fce7f3;
    }

    .sv-items-table thead th {
        padding: 0.6rem 0.75rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #c9a0b8;
        text-align: left;
    }

    .sv-items-table thead th:last-child {
        text-align: right;
    }

    .sv-items-table tbody tr {
        border-bottom: 1px solid #fdf2f8;
    }

    .sv-items-table tbody tr:last-child {
        border-bottom: none;
    }

    .sv-items-table tbody td {
        padding: 0.65rem 0.75rem;
        font-size: 0.88rem;
        color: #374151;
    }

    .sv-items-table tbody td:last-child {
        text-align: right;
        font-weight: 600;
        color: #1e1b2e;
    }

    .sv-items-table tfoot tr {
        border-top: 1.5px solid #fce7f3;
        background: #fffbfd;
    }

    .sv-items-table tfoot td {
        padding: 0.8rem 0.75rem;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #be185d;
    }

    .sv-items-table tfoot td:last-child {
        text-align: right;
        font-size: 1.1rem;
        font-weight: 700;
        color: #be185d;
    }

    .sv-parcel-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 1rem;
        background: #fdf2f8;
        border-radius: 12px;
        border: 1px solid #fce7f3;
        font-size: 0.82rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .sv-parcel-info strong {
        color: #be185d;
    }

    .sv-saldo-card {
        max-width: 640px;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.1rem 1.4rem;
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        border-radius: 18px;
        border: 1.5px solid #c4b5fd;
        box-shadow: 0 4px 16px #8b5cf620;
        animation: fadeUp 0.3s ease 0.05s both;
        flex-wrap: wrap;
    }

    .sv-saldo-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #6d28d9;
        margin: 0 0 0.15rem;
    }

    .sv-saldo-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #5b21b6;
        line-height: 1;
    }

    .sv-abater-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.7rem 1.2rem;
        border-radius: 12px;
        border: none;
        background: #7c3aed;
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 3px 12px #7c3aed30;
        white-space: nowrap;
    }

    .sv-abater-btn:hover {
        background: #6d28d9;
        transform: translateY(-1px);
        box-shadow: 0 5px 18px #7c3aed45;
    }

    .sv-parcela-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.9rem 0;
        border-bottom: 1px solid #fdf2f8;
    }

    .sv-parcela-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .sv-parcela-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        flex: 1;
    }

    .sv-check-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #fbc6d8;
        background: transparent;
        color: #d1a3bf;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
        padding: 0;
    }

    .sv-check-btn:hover {
        border-color: #10b981;
        color: #10b981;
        background: #ecfdf5;
    }

    .sv-check-done {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ecfdf5;
        border: 2px solid #6ee7b7;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #059669;
    }

    .sv-parcela-num {
        font-size: 0.88rem;
        font-weight: 600;
        color: #374151;
        margin: 0 0 0.1rem;
    }

    .sv-parcela-date {
        font-size: 0.74rem;
        color: #b0a0aa;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .sv-edit-date-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: #d1a3bf;
        padding: 0;
        display: inline-flex;
        align-items: center;
        transition: color 0.2s;
    }

    .sv-edit-date-btn:hover {
        color: #be185d;
    }

    .sv-parcela-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.3rem;
        flex-shrink: 0;
    }

    .sv-parcela-valor {
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e1b2e;
    }

    /* badges */
    .sv-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .sv-badge-dot {
        width: 4px;
        height: 4px;
        border-radius: 50%;
    }

    .badge-pago {
        background: #d1fae5;
        color: #059669;
    }

    .badge-pago .sv-badge-dot {
        background: #059669;
    }

    .badge-atrasado {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-atrasado .sv-badge-dot {
        background: #dc2626;
    }

    .badge-pendente {
        background: #fce7f3;
        color: #be185d;
    }

    .badge-pendente .sv-badge-dot {
        background: #ec4899;
    }

    .sv-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 50;
        background: #1e1b2e88;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .sv-modal-overlay.open {
        display: flex;
    }

    .sv-modal {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px #be185d20, 0 0 0 1px #fce7f3;
        width: 100%;
        max-width: 360px;
        overflow: hidden;
        animation: fadeUp 0.2s ease both;
    }

    .sv-modal-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #fce7f3;
    }

    .sv-modal-head h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.1rem;
        color: #1e1b2e;
        margin: 0 0 0.2rem;
    }

    .sv-modal-head p {
        font-size: 0.78rem;
        color: #9ca3af;
        margin: 0;
    }

    .sv-modal-body {
        padding: 1.25rem 1.5rem;
    }

    .sv-modal-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 0.4rem;
    }

    .sv-modal-input {
        width: 100%;
        padding: 0.7rem 1rem;
        border-radius: 12px;
        border: 1.5px solid #fce7f3;
        background: #fffbfd;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.9rem;
        color: #1e1b2e;
        outline: none;
        transition: all 0.2s;
        -webkit-appearance: none;
    }

    .sv-modal-input:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 4px #ec489912;
    }

    .sv-modal-input-money {
        padding-left: 2.5rem;
    }

    .sv-modal-money-prefix {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.8rem;
        font-weight: 700;
        color: #be185d;
        pointer-events: none;
    }

    .sv-modal-input-wrap {
        position: relative;
    }

    .sv-modal-foot {
        padding: 1rem 1.5rem;
        border-top: 1px solid #fce7f3;
        background: #fffbfd;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .sv-modal-cancel {
        background: none;
        border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #9ca3af;
        cursor: pointer;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .sv-modal-cancel:hover {
        color: #6b7280;
        background: #f3f4f6;
    }

    .sv-modal-confirm {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1.1rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #ec4899, #be185d);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 3px 12px #ec489930;
    }

    .sv-modal-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 18px #ec489945;
    }

    .sv-modal-confirm.violet {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        box-shadow: 0 3px 12px #7c3aed30;
    }

    .sv-modal-confirm.violet:hover {
        box-shadow: 0 5px 18px #7c3aed45;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(8px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

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
                <div class="sv-card-title-dot dot-pink"></div>
                Resumo da Venda
            </div>
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
</script>

@endsection