@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600;700&display=swap');

    .db-page * {
        box-sizing: border-box;
    }

    .db-page {
        min-height: 100vh;
        background: #fdf6f9;
        background-image:
            radial-gradient(ellipse at 0% 0%, #fce7f3 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, #fdf2f8 0%, transparent 50%);
        font-family: 'DM Sans', sans-serif;
        padding: 1.5rem 1rem 3rem;
    }

    .db-header {
        max-width: 1100px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .db-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 4vw, 2.4rem);
        color: #1e1b2e;
        margin: 0;
        line-height: 1.2;
    }

    .db-header p {
        font-size: 0.9rem;
        color: #9ca3af;
        margin: 0.3rem 0 0;
    }

    .db-stats-grid {
        max-width: 1100px;
        margin: 0 auto 2.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .db-stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.5rem;
        border: 1.5px solid #fce7f3;
        box-shadow: 0 4px 20px #be185d05;
        transition: transform 0.2s;
    }

    .db-stat-card:hover {
        transform: translateY(-3px);
    }

    .db-stat-card.primary {
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        border: none;
        color: white;
        box-shadow: 0 8px 25px #ec489930;
    }

    .db-stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9ca3af;
        margin-bottom: 0.5rem;
    }

    .primary .db-stat-label {
        color: #fce7f3;
    }

    .db-stat-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1e1b2e;
        margin: 0;
    }

    .primary .db-stat-value {
        color: white;
    }

    .db-stat-sub {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.4rem;
    }

    .primary .db-stat-sub {
        color: #fce7f3;
        opacity: 0.9;
    }

    .db-section-wrap {
        max-width: 1100px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    @media (max-width: 900px) {
        .db-section-wrap {
            grid-template-columns: 1fr;
        }
    }

    .db-section-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 1rem;
        color: #be185d;
    }

    .db-card {
        background: white;
        border-radius: 22px;
        border: 1.5px solid #fce7f3;
        box-shadow: 0 4px 20px #be185d08;
        overflow: hidden;
    }

    .db-table {
        width: 100%;
        border-collapse: collapse;
    }

    .db-table tr {
        border-bottom: 1px solid #fdf2f8;
        transition: background 0.15s;
    }

    .db-table tr:last-child {
        border-bottom: none;
    }

    .db-table tr:hover {
        background: #fffbfd;
    }

    .db-table td {
        padding: 1rem 1.25rem;
        font-size: 0.85rem;
    }

    .name-link {
        font-weight: 600;
        color: #ec4899;
        text-decoration: none;
    }

    .name-link:hover {
        text-decoration: underline;
    }

    .date-badge {
        font-size: 0.65rem;
        text-transform: uppercase;
        color: #9ca3af;
        display: block;
        margin-top: 2px;
    }

    .price-tag {
        font-weight: 700;
        color: #1e1b2e;
        text-align: right;
    }

    .price-tag.red {
        color: #dc2626;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #ec4899;
        display: inline-block;
        position: relative;
    }

    .status-dot.ping::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: #ec489940;
        animation: db-ping 1.5s ease-in-out infinite;
    }

    @keyframes db-ping {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.7;
        }

        50% {
            transform: scale(1.6);
            opacity: 0;
        }
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: #c9a0b8;
        font-size: 0.85rem;
        font-style: italic;
    }
</style>

<div class="db-page">

    <div class="db-header">
        <div>
            <h1>Dashboard</h1>
            <p>Bem-vinda de volta! Aqui está o resumo financeiro.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="an-count-badge" style="background: #fce7f3; color: #be185d; padding: 0.5rem 1rem; border-radius: 12px; font-weight: 700; font-size: 0.8rem;">
                {{ now()->format('d/m/Y') }}
            </span>
        </div>
    </div>

    <div class="db-stats-grid">
        <div class="db-stat-card primary">
            <p class="db-stat-label">Vendas Hoje</p>
            <p class="db-stat-value">R$ {{ number_format($valorVendasHoje, 2, ',', '.') }}</p>
            <p class="db-stat-sub">{{ $vendasHoje }} transações realizadas</p>
        </div>

        <div class="db-stat-card">
            <p class="db-stat-label">Total Pendente</p>
            <p class="db-stat-value" style="color: #d97706;">R$ {{ number_format($valorPendente, 2, ',', '.') }}</p>
            <p class="db-stat-sub">{{ $parcelasPendentes }} parcelas a receber</p>
        </div>

        <div class="db-stat-card">
            <p class="db-stat-label">Em Atraso</p>
            <p class="db-stat-value" style="color: #dc2626;">R$ {{ number_format($valorAtrasado, 2, ',', '.') }}</p>
            <p class="db-stat-sub">{{ $pagamentoAtrasado }} clientes inadimplentes</p>
        </div>

        <div class="db-stat-card">
            <p class="db-stat-label">Vence Hoje</p>
            <p class="db-stat-value">{{ $venceHoje }}</p>
            <p class="db-stat-sub">pagamentos aguardados</p>
        </div>
    </div>

    <div class="db-section-wrap">

        <div>
            <div class="db-section-label">
                <span class="status-dot ping" style="background: #dc2626;"></span>
                Pagamentos Atrasados
            </div>
            <div class="db-card">
                <table class="db-table">
                    <tbody>
                        @forelse ($atrasado as $venda)
                        @foreach ($venda->parcelas as $parcela)
                        <tr>
                            <td>
                                <a href="{{ route('vendas.show', $venda->id) }}" class="name-link">
                                    {{ $venda->cliente_nome }}
                                </a>
                                <span class="date-badge">Venceu em {{ $parcela->data_vencimento->format('d/m/Y') }}</span>
                            </td>
                            <td class="price-tag red">
                                R$ {{ number_format($parcela->valor, 2, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                        @empty
                        <tr>
                            <td class="empty-state">Nenhum pagamento atrasado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="db-section-label">
                <span class="status-dot" style="background: #ec4899;"></span>
                Vencendo nos próximos 7 dias
            </div>
            <div class="db-card">
                <table class="db-table">
                    <tbody>
                        @forelse ($vencendoEmBreve as $parcela)
                        @php
                        $diasRestantes = now()->startOfDay()->diffInDays($parcela->data_vencimento);
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('vendas.show', $parcela->venda_id) }}" class="name-link" style="color: #1e1b2e;">
                                    {{ $parcela->venda->cliente_nome }}
                                </a>
                                <span class="date-badge" style="color: #be185d; font-weight: 600;">
                                    {{ $diasRestantes == 0 ? 'Vence hoje' : ($diasRestantes == 1 ? 'Vence amanhã' : "Em $diasRestantes dias") }}
                                </span>
                            </td>
                            <td class="price-tag">
                                R$ {{ number_format($parcela->valor, 2, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="empty-state">Tudo em dia por aqui!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection