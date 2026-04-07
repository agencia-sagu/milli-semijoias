@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    .nova-venda * {
        box-sizing: border-box;
    }

    .nova-venda {
        min-height: 100vh;
        background: #fdf6f9;
        background-image:
            radial-gradient(ellipse at 0% 0%, #fce7f3 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, #fdf2f8 0%, transparent 50%);
        font-family: 'DM Sans', sans-serif;
        padding: 1.5rem 1rem 3rem;
    }

    .nv-header {
        max-width: 700px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .nv-back-btn {
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

    .nv-back-btn:hover {
        background: #fdf2f8;
        border-color: #ec4899;
        box-shadow: 0 4px 12px #ec489920;
        transform: translateX(-2px);
    }

    .nv-title-block h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.4rem, 4vw, 1.9rem);
        color: #1e1b2e;
        margin: 0;
        line-height: 1.2;
    }

    .nv-title-block p {
        font-size: 0.85rem;
        color: #9ca3af;
        margin: 0.2rem 0 0;
    }

    .nv-card {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 24px;
        box-shadow:
            0 1px 3px #00000008,
            0 8px 32px #be185d0d,
            0 0 0 1px #fce7f3;
        overflow: hidden;
    }

    .nv-form {
        padding: clamp(1.25rem, 5vw, 2.25rem);
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .nv-section {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .nv-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #fce7f3;
    }

    .nv-section-label {
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .nv-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
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

    .nv-section-label span {
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #6b7280;
    }

    .nv-section-label span.pink {
        color: #be185d;
    }

    .nv-field {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .nv-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        letter-spacing: 0.02em;
    }

    .nv-input-wrap {
        position: relative;
    }

    .nv-input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #d1a3bf;
        display: flex;
        align-items: center;
        pointer-events: none;
    }

    .nv-input {
        width: 100%;
        padding: 0.7rem 1rem 0.7rem 2.6rem;
        border-radius: 12px;
        border: 1.5px solid #fce7f3;
        background: #fffbfd;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.92rem;
        color: #1e1b2e;
        outline: none;
        transition: all 0.2s;
        -webkit-appearance: none;
    }

    .nv-input::placeholder {
        color: #d1b0c1;
    }

    .nv-input:focus {
        border-color: #ec4899;
        background: white;
        box-shadow: 0 0 0 4px #ec489912;
    }

    .nv-input.no-icon {
        padding-left: 1rem;
    }

    .nv-select-wrap {
        position: relative;
    }

    .nv-select-wrap::after {
        content: '';
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 6px solid #d1a3bf;
        pointer-events: none;
    }

    .nv-select {
        width: 100%;
        padding: 0.7rem 2.2rem 0.7rem 1rem;
        border-radius: 12px;
        border: 1.5px solid #fce7f3;
        background: #fffbfd;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.92rem;
        color: #1e1b2e;
        outline: none;
        appearance: none;
        -webkit-appearance: none;
        transition: all 0.2s;
    }

    .nv-select:focus {
        border-color: #ec4899;
        background: white;
        box-shadow: 0 0 0 4px #ec489912;
    }

    .nv-item-row {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 0.6rem;
        align-items: center;
    }

    .nv-item-price-wrap {
        width: 110px;
    }

    .nv-price-input-wrap {
        position: relative;
    }

    .nv-price-prefix {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        font-weight: 700;
        color: #be185d;
        pointer-events: none;
    }

    .nv-price-input {
        width: 100%;
        padding: 0.7rem 0.6rem 0.7rem 2rem;
        border-radius: 12px;
        border: 1.5px solid #fce7f3;
        background: #fffbfd;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        color: #be185d;
        outline: none;
        transition: all 0.2s;
        -webkit-appearance: none;
    }

    .nv-price-input:focus {
        border-color: #ec4899;
        background: white;
        box-shadow: 0 0 0 4px #ec489912;
    }

    .nv-remove-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        border: none;
        background: transparent;
        color: #d1a3bf;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .nv-remove-btn:hover {
        background: #fff1f5;
        color: #e11d48;
    }

    .nv-placeholder-spacer {
        width: 36px;
        flex-shrink: 0;
    }

    .nv-add-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 0.9rem;
        border-radius: 10px;
        border: 1.5px dashed #f9a8d4;
        background: transparent;
        color: #be185d;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .nv-add-btn:hover {
        background: #fdf2f8;
        border-color: #ec4899;
        border-style: solid;
    }

    .nv-toggle-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.1rem;
        border-radius: 14px;
        border: 1.5px solid #fce7f3;
        background: #fffbfd;
        cursor: pointer;
        transition: all 0.2s;
    }

    .nv-toggle-card:hover {
        border-color: #f9a8d4;
        background: #fdf2f8;
    }

    .nv-toggle-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #fce7f3;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        color: #be185d;
    }

    .nv-toggle-text {
        flex: 1;
    }

    .nv-toggle-text strong {
        display: block;
        font-size: 0.88rem;
        font-weight: 600;
        color: #1e1b2e;
    }

    .nv-toggle-text span {
        font-size: 0.76rem;
        color: #9ca3af;
    }

    .nv-switch {
        position: relative;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }

    .nv-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .nv-slider {
        position: absolute;
        inset: 0;
        border-radius: 999px;
        background: #e5e7eb;
        cursor: pointer;
        transition: background 0.25s;
    }

    .nv-slider::before {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: white;
        top: 3px;
        left: 3px;
        transition: transform 0.25s;
        box-shadow: 0 1px 4px #0000001a;
    }

    .nv-switch input:checked+.nv-slider {
        background: #ec4899;
    }

    .nv-switch input:checked+.nv-slider::before {
        transform: translateX(20px);
    }

    .nv-financial-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    @media (max-width: 520px) {
        .nv-financial-grid {
            grid-template-columns: 1fr;
        }

        .nv-item-price-wrap {
            width: 90px;
        }
    }

    .nv-total-box {
        grid-column: 1 / -1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.25rem;
        border-radius: 14px;
        background: linear-gradient(135deg, #fdf2f8 0%, #fce7f3 100%);
        border: 1.5px solid #f9a8d4;
    }

    .nv-total-label {
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #be185d;
    }

    .nv-total-value {
        display: flex;
        align-items: baseline;
        gap: 0.3rem;
    }

    .nv-total-currency {
        font-size: 0.9rem;
        font-weight: 700;
        color: #be185d;
    }

    .nv-total-amount {
        font-family: 'DM Sans', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #be185d;
        line-height: 1;
        min-width: 80px;
        text-align: right;
    }

    .nv-total-hidden {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }

    .nv-actions {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 0.75rem;
        padding-top: 1.25rem;
        border-top: 1px solid #fce7f3;
    }

    @media (max-width: 420px) {
        .nv-actions {
            grid-template-columns: 1fr;
        }
    }

    .nv-btn-confirm {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.5rem;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.92rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s;
        box-shadow: 0 4px 18px #ec489940;
        letter-spacing: 0.02em;
    }

    .nv-btn-confirm:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 24px #ec489955;
    }

    .nv-btn-confirm:active {
        transform: translateY(0);
    }

    .nv-btn-discard {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        padding: 0.85rem 1.25rem;
        border-radius: 14px;
        border: 1.5px solid #fce7f3;
        background: white;
        color: #9ca3af;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .nv-btn-discard:hover {
        border-color: #fca5a5;
        color: #ef4444;
        background: #fff5f5;
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

    .nv-card {
        animation: fadeUp 0.35s ease both;
    }

    .item-row-anim {
        animation: fadeUp 0.2s ease both;
    }
</style>

<div class="nova-venda">

    <div class="nv-header">
        <a href="/" class="nv-back-btn" aria-label="Voltar">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m12 19-7-7 7-7" />
                <path d="M19 12H5" />
            </svg>
        </a>
        <div class="nv-title-block">
            <h1>Nova Venda</h1>
            <p>Preencha os dados abaixo para registrar</p>
        </div>
    </div>

    <div class="nv-card">
        <form action="{{ route('vendas.store') }}" method="POST" class="nv-form">
            @csrf

            <div class="nv-section">
                <div class="nv-section-header">
                    <div class="nv-section-label">
                        <div class="nv-dot dot-pink"></div>
                        <span class="pink">Dados do Cliente</span>
                    </div>
                </div>

                <div class="nv-field">
                    <label class="nv-label" for="customerName">Nome completo</label>
                    <div class="nv-input-wrap">
                        <span class="nv-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>
                        <input type="text" name="cliente_nome" id="customerName" class="nv-input"
                            placeholder="Ex: Maria da Silva" required>
                    </div>
                </div>

                <div class="nv-field">
                    <label class="nv-label" for="cpf">CPF <span style="color:#d1a3bf;font-weight:400">(opcional)</span></label>
                    <div class="nv-input-wrap">
                        <span class="nv-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="M7 9h.01" />
                                <path d="M11 9h6" />
                                <path d="M7 13h10" />
                            </svg>
                        </span>
                        <input type="text" name="cpf" id="cpf" class="nv-input"
                            placeholder="000.000.000-00">
                    </div>
                </div>
            </div>

            <div class="nv-section">
                <div class="nv-section-header">
                    <div class="nv-section-label">
                        <div class="nv-dot dot-violet"></div>
                        <span>Itens / Peças</span>
                    </div>
                    <button type="button" id="add-item" class="nv-add-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                        Adicionar
                    </button>
                </div>

                <div id="items-container" style="display:flex;flex-direction:column;gap:0.5rem;">
                    <div class="nv-item-row item-row">
                        <div class="nv-input-wrap">
                            <span class="nv-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8" />
                                    <path d="M2 7h20" />
                                </svg>
                            </span>
                            <input type="text" name="items[]" class="nv-input"
                                placeholder="Nome da peça" required>
                        </div>
                        <div class="nv-item-price-wrap">
                            <div class="nv-price-input-wrap">
                                <span class="nv-price-prefix">R$</span>
                                <input type="number" name="item_prices[]" step="0.01"
                                    class="item-price nv-price-input"
                                    placeholder="0,00" required>
                            </div>
                        </div>
                        <div class="nv-placeholder-spacer"></div>
                    </div>
                </div>
            </div>

            <div class="nv-section">
                <div class="nv-section-header">
                    <div class="nv-section-label">
                        <div class="nv-dot dot-emerald"></div>
                        <span>Financeiro</span>
                    </div>
                </div>

                <label class="nv-toggle-card" for="is_flexivel">
                    <div class="nv-toggle-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 12V8H4v4" />
                            <path d="M2 12h20" />
                            <path d="M20 12v8H4v-8" />
                        </svg>
                    </div>
                    <div class="nv-toggle-text">
                        <strong>Pagamento Flexível</strong>
                        <span>Cliente paga valores variados em datas diversas</span>
                    </div>
                    <label class="nv-switch">
                        <input type="checkbox" name="is_flexivel" id="is_flexivel" value="1">
                        <span class="nv-slider"></span>
                    </label>
                </label>

                <div class="nv-financial-grid">
                    <div class="nv-total-box" style="grid-column: 1 / -1;">
                        <div class="nv-total-label">Total da venda</div>
                        <div class="nv-total-value">
                            <span class="nv-total-currency">R$</span>
                            <span class="nv-total-amount" id="total-display">0,00</span>
                        </div>
                        <input type="number" name="valor_total" id="amount" step="0.01"
                            class="nv-total-hidden" readonly>
                    </div>

                    <div id="container-parcelas" style="display:contents;">
                        <div class="nv-field">
                            <label class="nv-label" for="installments">Parcelas</label>
                            <div class="nv-select-wrap">
                                <select name="quantidade_parcelas" id="installments" class="nv-select">
                                    <option value="1">1× — À vista</option>
                                    <option value="2">2×</option>
                                    <option value="3">3×</option>
                                    <option value="4">4×</option>
                                    <option value="5">5×</option>
                                    <option value="6">6×</option>
                                    <option value="7">7×</option>
                                    <option value="8">8×</option>
                                    <option value="9">9×</option>
                                    <option value="10">10×</option>
                                    <option value="11">11×</option>
                                    <option value="12">12×</option>
                                </select>
                            </div>
                        </div>

                        <div class="nv-field">
                            <label class="nv-label" for="paymentDate">1º Vencimento</label>
                            <input type="date" name="data_vencimento" id="paymentDate"
                                class="nv-input no-icon" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="nv-actions">
                <button type="submit" class="nv-btn-confirm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Confirmar Venda
                </button>
                <a href="{{ route('vendas.index') }}" class="nv-btn-discard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                    Descartar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const checkFlexivel = document.getElementById('is_flexivel');
    const parcSelects = document.querySelectorAll('#container-parcelas .nv-field');
    const inputDataVenc = document.getElementById('paymentDate');
    const parcContainer = document.getElementById('container-parcelas');

    checkFlexivel.addEventListener('change', function() {
        const fields = parcContainer.querySelectorAll('.nv-field');
        fields.forEach(f => {
            f.style.display = this.checked ? 'none' : '';
        });
        inputDataVenc.required = !this.checked;
    });

    const container = document.getElementById('items-container');
    const totalInput = document.getElementById('amount');
    const totalDisplay = document.getElementById('total-display');

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-price').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        totalInput.value = total.toFixed(2);
        totalDisplay.textContent = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    container.addEventListener('input', e => {
        if (e.target.classList.contains('item-price')) calculateTotal();
    });


    document.getElementById('add-item').addEventListener('click', function() {
        const row = document.createElement('div');
        row.className = 'nv-item-row item-row item-row-anim';
        row.innerHTML = `
        <div class="nv-input-wrap">
            <span class="nv-input-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/>
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/>
                    <path d="M2 7h20"/>
                </svg>
            </span>
            <input type="text" name="items[]" class="nv-input"
                   placeholder="Outro item..." required>
        </div>
        <div class="nv-item-price-wrap">
            <div class="nv-price-input-wrap">
                <span class="nv-price-prefix">R$</span>
                <input type="number" name="item_prices[]" step="0.01"
                       class="item-price nv-price-input" placeholder="0,00" required>
            </div>
        </div>
        <button type="button" class="remove-item nv-remove-btn" title="Remover">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 6h18"/>
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
            </svg>
        </button>
    `;
        container.appendChild(row);
    });


    container.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
            calculateTotal();
        }
    });


    document.getElementById('cpf').addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        e.target.value = v;
    });
</script>

@endsection