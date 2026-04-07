@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    .vi-page * {
        box-sizing: border-box;
    }

    .vi-page {
        min-height: 100vh;
        background: #fdf6f9;
        background-image:
            radial-gradient(ellipse at 0% 0%, #fce7f3 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, #fdf2f8 0%, transparent 50%);
        font-family: 'DM Sans', sans-serif;
        padding: 1.5rem 1rem 3rem;
    }

    .vi-header {
        max-width: 900px;
        margin: 0 auto 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .vi-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.5rem, 4vw, 2rem);
        color: #1e1b2e;
        margin: 0;
        line-height: 1.2;
    }

    .vi-header p {
        font-size: 0.83rem;
        color: #9ca3af;
        margin: 0.2rem 0 0;
    }

    .vi-new-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.7rem 1.2rem;
        border-radius: 14px;
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: 0 4px 16px #ec489938;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .vi-new-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 22px #ec489950;
    }

    .vi-tabs-wrap {
        max-width: 900px;
        margin: 0 auto 1.25rem;
        overflow-x: auto;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .vi-tabs-wrap::-webkit-scrollbar {
        display: none;
    }

    .vi-tabs {
        display: inline-flex;
        gap: 0.25rem;
        background: white;
        border: 1.5px solid #fce7f3;
        border-radius: 14px;
        padding: 0.3rem;
        white-space: nowrap;
    }

    .vi-tab {
        padding: 0.45rem 1rem;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        color: #9ca3af;
        transition: all 0.2s;
    }

    .vi-tab:hover {
        color: #6b7280;
        background: #fdf2f8;
    }

    .vi-tab.active-all {
        background: #fce7f3;
        color: #be185d;
    }

    .vi-tab.active-pend {
        background: #fce7f3;
        color: #be185d;
    }

    .vi-tab.active-atras {
        background: #fee2e2;
        color: #dc2626;
    }

    .vi-tab.active-pago {
        background: #d1fae5;
        color: #059669;
    }

    .vi-flash {
        max-width: 900px;
        margin: 0 auto 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.8rem 1.1rem;
        background: #ecfdf5;
        border: 1.5px solid #a7f3d0;
        color: #065f46;
        border-radius: 14px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .vi-search-wrap {
        max-width: 900px;
        margin: 0 auto 1.5rem;
        display: flex;
        gap: 0.6rem;
    }

    .vi-search-inner {
        position: relative;
        flex: 1;
    }

    .vi-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #d1a3bf;
        pointer-events: none;
        display: flex;
    }

    .vi-search-input {
        width: 100%;
        padding: 0.7rem 2.5rem 0.7rem 2.6rem;
        border-radius: 12px;
        border: 1.5px solid #fce7f3;
        background: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        color: #1e1b2e;
        outline: none;
        transition: all 0.2s;
    }

    .vi-search-input::placeholder {
        color: #d1b0c1;
    }

    .vi-search-input:focus {
        border-color: #ec4899;
        box-shadow: 0 0 0 4px #ec489912;
    }

    .vi-search-clear {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #d1a3bf;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }

    .vi-search-clear:hover {
        color: #be185d;
    }

    .vi-search-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #ec4899, #be185d);
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
        box-shadow: 0 3px 10px #ec489930;
    }

    .vi-search-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px #ec489940;
    }

    .vi-cards {
        max-width: 900px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    @media (min-width: 768px) {
        .vi-cards {
            display: none;
        }
    }

    .vi-card {
        background: white;
        border-radius: 18px;
        border: 1.5px solid #fce7f3;
        padding: 1rem 1.1rem;
        box-shadow: 0 2px 12px #be185d08;
        animation: fadeUp 0.3s ease both;
    }

    .vi-card-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
    }

    .vi-card-name {
        font-weight: 700;
        font-size: 0.92rem;
        color: #1e1b2e;
        margin: 0 0 0.15rem;
    }

    .vi-card-item {
        font-size: 0.76rem;
        color: #b0a0aa;
        margin: 0;
    }

    .vi-card-value {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.95rem;
        font-weight: 700;
        color: #be185d;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .vi-card-mid {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.85rem;
    }

    .vi-progress-bar {
        flex: 1;
        height: 5px;
        background: #fce7f3;
        border-radius: 999px;
        overflow: hidden;
    }

    .vi-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f9a8d4, #ec4899);
        border-radius: 999px;
        transition: width 0.6s ease;
    }

    .vi-progress-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #6b7280;
        white-space: nowrap;
    }

    .vi-card-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px solid #fce7f3;
    }

    .vi-table-wrap {
        max-width: 900px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        border: 1.5px solid #fce7f3;
        box-shadow: 0 4px 24px #be185d0a;
        overflow: hidden;
        display: none;
    }

    @media (min-width: 768px) {
        .vi-table-wrap {
            display: block;
        }
    }

    .vi-table {
        width: 100%;
        border-collapse: collapse;
    }

    .vi-table thead tr {
        background: #fffbfd;
        border-bottom: 1.5px solid #fce7f3;
    }

    .vi-table thead th {
        padding: 0.9rem 1.25rem;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #c9a0b8;
        text-align: left;
    }

    .vi-table thead th:last-child {
        text-align: right;
    }

    .vi-table tbody tr {
        border-bottom: 1px solid #fdf2f8;
        transition: background 0.15s;
    }

    .vi-table tbody tr:last-child {
        border-bottom: none;
    }

    .vi-table tbody tr:hover {
        background: #fffbfd;
    }

    .vi-table td {
        padding: 0.9rem 1.25rem;
        vertical-align: middle;
    }

    .vi-td-name {
        font-weight: 700;
        font-size: 0.88rem;
        color: #1e1b2e;
        transition: color 0.2s;
    }

    .vi-table tbody tr:hover .vi-td-name {
        color: #be185d;
    }

    .vi-td-sub {
        font-size: 0.75rem;
        color: #c9a0b8;
        margin-top: 0.1rem;
    }

    .vi-td-value {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.92rem;
        font-weight: 700;
        color: #1e1b2e;
    }

    .vi-bar-wrap {
        width: 100px;
    }

    .vi-bar-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: #6b7280;
        margin-bottom: 0.3rem;
    }

    .vi-bar {
        height: 5px;
        background: #fce7f3;
        border-radius: 999px;
        overflow: hidden;
    }

    .vi-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #f9a8d4, #ec4899);
        border-radius: 999px;
    }

    .vi-td-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.2rem;
    }

    .vi-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 8px;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.07em;
    }

    .vi-badge-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
    }

    .badge-pendente {
        background: #fce7f3;
        color: #be185d;
    }

    .badge-pendente .vi-badge-dot {
        background: #ec4899;
    }

    .badge-atrasado {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-atrasado .vi-badge-dot {
        background: #dc2626;
    }

    .badge-pago {
        background: #d1fae5;
        color: #059669;
    }

    .badge-pago .vi-badge-dot {
        background: #059669;
    }

    .badge-flexivel {
        background: #ede9fe;
        color: #7c3aed;
    }

    .badge-flexivel .vi-badge-dot {
        background: #7c3aed;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.4;
        }
    }

    .vi-action-btn {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        border: none;
        background: transparent;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #c9a0b8;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 0;
    }

    .vi-action-btn.view:hover {
        background: #fce7f3;
        color: #be185d;
    }

    .vi-action-btn.edit:hover {
        background: #fef3c7;
        color: #d97706;
    }

    .vi-action-btn.del:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .vi-pagination {
        max-width: 900px;
        margin: 1.5rem auto 0;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .vi-table-wrap {
        animation: fadeUp 0.3s ease both;
    }
</style>

<div class="vi-page">

    <div class="vi-header">
        <div>
            <h1>Vendas</h1>
            <p>Gerencie pagamentos e contratos</p>
        </div>
        <a href="{{ route('vendas.create') }}" class="vi-new-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Nova Venda
        </a>
    </div>

    @php $currentStatus = request('status'); @endphp
    <div class="vi-tabs-wrap">
        <div class="vi-tabs">
            <a href="{{ route('vendas.index') }}"
                class="vi-tab {{ !$currentStatus ? 'active-all' : '' }}">
                Todos
            </a>
            <a href="{{ route('vendas.index', ['status' => 'pendente']) }}"
                class="vi-tab {{ $currentStatus === 'pendente' ? 'active-pend' : '' }}">
                Pendentes
            </a>
            <a href="{{ route('vendas.index', ['status' => 'atrasado']) }}"
                class="vi-tab {{ $currentStatus === 'atrasado' ? 'active-atras' : '' }}">
                Atrasados
            </a>
            <a href="{{ route('vendas.index', ['status' => 'pago']) }}"
                class="vi-tab {{ $currentStatus === 'pago' ? 'active-pago' : '' }}">
                Pagos
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="vi-flash">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
            fill="none" stroke="currentColor" stroke-width="2.5"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <form method="GET" action="{{ route('vendas.index') }}">
        @if($currentStatus)
        <input type="hidden" name="status" value="{{ $currentStatus }}">
        @endif
        <div class="vi-search-wrap">
            <div class="vi-search-inner">
                <span class="vi-search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </span>
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Buscar por cliente ou item..."
                    class="vi-search-input">
                @if(request('q'))
                <a href="{{ route('vendas.index', array_filter(['status' => $currentStatus])) }}"
                    class="vi-search-clear">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </a>
                @endif
            </div>
            <button type="submit" class="vi-search-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </button>
        </div>
    </form>

    <div class="vi-cards">
        @foreach ($vendas as $venda)
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
        $status = $venda->status_geral;
        @endphp
        <div class="vi-card">
            <div class="vi-card-top">
                <div>
                    <p class="vi-card-name">{{ $venda->cliente_nome }}</p>
                    <p class="vi-card-item">{{ Str::limit($venda->item, 30) }}</p>
                </div>
                <span class="vi-card-value">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
            </div>

            <div class="vi-card-mid">
                <div class="vi-progress-bar">
                    <div class="vi-progress-fill" style="width: {{ $percent }}%"></div>
                </div>
                <span class="vi-progress-label">{{ $label }}</span>
            </div>

            <div class="vi-card-bottom">
                @if($venda->is_flexivel && $status !== 'pago')
                <span class="vi-badge badge-flexivel">
                    <span class="vi-badge-dot"></span>Flexível
                </span>
                @else
                <span class="vi-badge badge-{{ $status }}">
                    <span class="vi-badge-dot"></span>{{ ucfirst($status) }}
                </span>
                @endif

                <div style="display:flex;gap:0.2rem;">
                    <a href="{{ route('vendas.show', $venda->id) }}" class="vi-action-btn view" title="Ver">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </a>
                    <a href="{{ route('vendas.edit', $venda->id) }}" class="vi-action-btn edit" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                        </svg>
                    </a>
                    <form action="{{ route('vendas.excluir', $venda->id) }}" method="POST" class="inline"
                        onsubmit="return confirm('Excluir esta venda?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="vi-action-btn del" title="Excluir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
        </div>
        @endforeach
    </div>

    <div class="vi-table-wrap">
        <table class="vi-table">
            <thead>
                <tr>
                    <th>Cliente / Item</th>
                    <th>Valor</th>
                    <th>Progresso</th>
                    <th>Status</th>
                    <th style="text-align:right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vendas as $venda)
                @php
                if($venda->is_flexivel) {
                $pago = $venda->parcelas->where('pago', true)->sum('valor');
                $percent = ($venda->valor_total > 0) ? ($pago / $venda->valor_total) * 100 : 0;
                $label = number_format($percent, 0) . '%';
                } else {
                $pagoCount = $venda->parcelas->where('pago', true)->count();
                $percent = ($venda->quantidade_parcelas > 0) ? ($pagoCount / $venda->quantidade_parcelas) * 100 : 0;
                $label = "{$pagoCount}/{$venda->quantidade_parcelas}";
                }
                $status = $venda->status_geral;
                @endphp
                <tr>
                    <td>
                        <div class="vi-td-name">{{ $venda->cliente_nome }}</div>
                        <div class="vi-td-sub">{{ Str::limit($venda->item, 42) }}</div>
                    </td>
                    <td>
                        <span class="vi-td-value">R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</span>
                    </td>
                    <td>
                        <div class="vi-bar-wrap">
                            <div class="vi-bar-label">{{ $label }}</div>
                            <div class="vi-bar">
                                <div class="vi-bar-fill" style="width: {{ $percent }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($venda->is_flexivel && $status !== 'pago')
                        <span class="vi-badge badge-flexivel">
                            <span class="vi-badge-dot"></span>Flexível
                        </span>
                        @else
                        <span class="vi-badge badge-{{ $status }}">
                            <span class="vi-badge-dot"></span>{{ ucfirst($status) }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="vi-td-actions">
                            <a href="{{ route('vendas.show', $venda->id) }}" class="vi-action-btn view" title="Ver">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </a>
                            <a href="{{ route('vendas.edit', $venda->id) }}" class="vi-action-btn edit" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 20h9" />
                                    <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                </svg>
                            </a>
                            <form action="{{ route('vendas.excluir', $venda->id) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Excluir esta venda?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="vi-action-btn del" title="Excluir">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18" />
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        <line x1="10" x2="10" y1="11" y2="17" />
                                        <line x1="14" x2="14" y1="11" y2="17" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="vi-pagination">
        {{ $vendas->links() }}
    </div>

</div>

@endsection