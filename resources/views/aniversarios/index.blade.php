@extends('layouts.app')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap');

    .an-page * { box-sizing: border-box; }

    .an-page {
        min-height: 100vh;
        background: #fdf6f9;
        background-image:
            radial-gradient(ellipse at 0% 0%, #fce7f3 0%, transparent 50%),
            radial-gradient(ellipse at 100% 100%, #fdf2f8 0%, transparent 50%);
        font-family: 'DM Sans', sans-serif;
        padding: 1.5rem 1rem 3rem;
    }

    /* ── HEADER ── */
    .an-header {
        max-width: 960px;
        margin: 0 auto 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .an-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.5rem, 4vw, 2rem);
        color: #1e1b2e;
        margin: 0; line-height: 1.2;
    }
    .an-header p { font-size: 0.83rem; color: #9ca3af; margin: 0.2rem 0 0; }

    .an-new-btn {
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
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.25s;
        box-shadow: 0 4px 16px #ec489938;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .an-new-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 22px #ec489950; }

    /* ── GRID HOJE + PRÓXIMOS ── */
    .an-top-grid {
        max-width: 960px;
        margin: 0 auto 2rem;
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1.25rem;
    }
    @media (max-width: 700px) {
        .an-top-grid { grid-template-columns: 1fr; }
    }

    /* ── SECTION LABEL ── */
    .an-section-label {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.85rem;
    }
    .an-section-label.pink { color: #be185d; }
    .an-section-label.grey { color: #9ca3af; }

    .an-ping-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: #ec4899;
        position: relative;
        flex-shrink: 0;
    }
    .an-ping-dot::after {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 50%;
        background: #ec489940;
        animation: pingAnim 1.5s ease-in-out infinite;
    }
    @keyframes pingAnim {
        0%, 100% { transform: scale(1); opacity: 0.7; }
        50%       { transform: scale(1.6); opacity: 0; }
    }

    /* ── CARD ANIVERSÁRIO HOJE ── */
    .an-hoje-card {
        background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);
        border-radius: 18px;
        padding: 1.25rem 1.3rem;
        box-shadow: 0 6px 24px #ec489938;
        position: relative;
        overflow: hidden;
        margin-bottom: 0.75rem;
        animation: fadeUp 0.3s ease both;
    }
    .an-hoje-card-name {
        font-weight: 700;
        font-size: 1rem;
        color: white;
        margin: 0 0 0.2rem;
    }
    .an-hoje-card-age { font-size: 0.82rem; color: #fce7f3; margin: 0 0 0.8rem; }
    .an-hoje-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.75rem;
        background: rgba(255,255,255,0.2);
        border-radius: 8px;
        font-size: 0.72rem;
        font-weight: 800;
        color: white;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        backdrop-filter: blur(4px);
    }
    .an-hoje-deco {
        position: absolute;
        right: -12px; bottom: -12px;
        font-size: 4rem;
        opacity: 0.12;
        pointer-events: none;
        line-height: 1;
    }

    .an-empty {
        background: white;
        border: 1.5px dashed #fbc6d8;
        border-radius: 16px;
        padding: 2rem 1rem;
        text-align: center;
        color: #c9a0b8;
        font-size: 0.83rem;
    }

    /* ── PRÓXIMOS CARD ── */
    .an-card {
        background: white;
        border-radius: 20px;
        border: 1.5px solid #fce7f3;
        box-shadow: 0 4px 20px #be185d08;
        overflow: hidden;
        animation: fadeUp 0.3s ease both;
    }

    .an-mes-table { width: 100%; border-collapse: collapse; }
    .an-mes-table tbody tr { border-bottom: 1px solid #fdf2f8; transition: background 0.15s; }
    .an-mes-table tbody tr:last-child { border-bottom: none; }
    .an-mes-table tbody tr:hover { background: #fffbfd; }
    .an-mes-table td { padding: 0.8rem 1.1rem; font-size: 0.88rem; color: #374151; }
    .an-mes-table .td-name { font-weight: 600; color: #1e1b2e; }
    .an-mes-table .td-day { text-align: center; }

    .an-day-chip {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 42px; height: 42px;
        border-radius: 12px;
        background: #fce7f3;
        transition: background 0.2s;
    }
    .an-mes-table tbody tr:hover .an-day-chip { background: #fdf2f8; }
    .an-day-chip-label { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.08em; color: #c9a0b8; }
    .an-day-chip-num   { font-size: 0.9rem; font-weight: 800; color: #be185d; line-height: 1; }

    /* ── BASE GERAL ── */
    .an-section-wrap { max-width: 960px; margin: 0 auto; }

    .an-section-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.85rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .an-count-badge {
        font-size: 0.75rem;
        font-weight: 700;
        color: #c9a0b8;
        background: #fce7f3;
        padding: 0.25rem 0.7rem;
        border-radius: 8px;
    }

    .an-table { width: 100%; border-collapse: collapse; }
    .an-table thead tr {
        background: #fffbfd;
        border-bottom: 1.5px solid #fce7f3;
    }
    .an-table thead th {
        padding: 0.85rem 1.25rem;
        font-size: 0.68rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #c9a0b8;
        text-align: left;
    }
    .an-table thead th.center { text-align: center; }
    .an-table thead th.right  { text-align: right; }

    .an-table tbody tr { border-bottom: 1px solid #fdf2f8; transition: background 0.15s; }
    .an-table tbody tr:last-child { border-bottom: none; }
    .an-table tbody tr:hover { background: #fffbfd; }
    .an-table td { padding: 0.85rem 1.25rem; font-size: 0.88rem; color: #374151; }
    .an-table td.center { text-align: center; }
    .an-table td.right  { text-align: right; }

    .an-td-name { font-weight: 600; color: #1e1b2e; }

    .an-age-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.65rem;
        border-radius: 8px;
        background: #fce7f3;
        font-size: 0.75rem;
        font-weight: 700;
        color: #be185d;
    }

    .an-del-btn {
        width: 32px; height: 32px;
        border-radius: 9px;
        border: none;
        background: transparent;
        color: #d1a3bf;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .an-del-btn:hover { background: #fee2e2; color: #dc2626; }

    .an-table-empty {
        padding: 3rem 1rem;
        text-align: center;
        color: #c9a0b8;
        font-size: 0.85rem;
    }

    /* ── MODAL ── */
    .an-modal-overlay {
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
    .an-modal-overlay.open { display: flex; }

    .an-modal {
        background: white;
        border-radius: 22px;
        box-shadow: 0 20px 60px #be185d22, 0 0 0 1px #fce7f3;
        width: 100%;
        max-width: 380px;
        overflow: hidden;
        animation: fadeUp 0.22s ease both;
    }

    .an-modal-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #fce7f3;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 1rem;
    }
    .an-modal-head h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        color: #1e1b2e;
        margin: 0 0 0.15rem;
    }
    .an-modal-head p { font-size: 0.78rem; color: #9ca3af; margin: 0; }

    .an-modal-close {
        width: 32px; height: 32px;
        border-radius: 9px;
        border: none;
        background: transparent;
        color: #c9a0b8;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .an-modal-close:hover { background: #fce7f3; color: #be185d; }

    .an-modal-body {
        padding: 1.25rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .an-modal-field { display: flex; flex-direction: column; gap: 0.4rem; }
    .an-modal-label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #374151;
        letter-spacing: 0.02em;
    }
    .an-modal-input {
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
    .an-modal-input::placeholder { color: #d1b0c1; }
    .an-modal-input:focus { border-color: #ec4899; background: white; box-shadow: 0 0 0 4px #ec489912; }

    .an-modal-foot {
        padding: 1rem 1.5rem;
        border-top: 1px solid #fce7f3;
        background: #fffbfd;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.6rem;
    }
    .an-modal-cancel {
        background: none; border: none;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem; font-weight: 600;
        color: #9ca3af; cursor: pointer;
        padding: 0.5rem 0.75rem;
        border-radius: 10px;
        transition: all 0.2s;
    }
    .an-modal-cancel:hover { color: #6b7280; background: #f3f4f6; }

    .an-modal-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1.2rem;
        border-radius: 12px;
        border: none;
        background: linear-gradient(135deg, #ec4899, #be185d);
        color: white;
        font-family: 'DM Sans', sans-serif;
        font-size: 0.85rem; font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 3px 12px #ec489930;
    }
    .an-modal-submit:hover { transform: translateY(-1px); box-shadow: 0 5px 18px #ec489945; }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="an-page">

    {{-- ── HEADER ── --}}
    <div class="an-header">
        <div>
            <h1>Aniversariantes</h1>
            <p>Gestão de clientes e datas especiais</p>
        </div>
        <button class="an-new-btn" onclick="document.getElementById('modalCadastro').classList.add('open')">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="3"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14"/><path d="M12 5v14"/>
            </svg>
            Cadastrar Cliente
        </button>
    </div>

    {{-- ── HOJE + PRÓXIMOS ── --}}
    <div class="an-top-grid">

        {{-- Hoje --}}
        <div>
            <div class="an-section-label pink">
                <span class="an-ping-dot"></span>
                Hoje — {{ now()->format('d/m') }}
            </div>

            @forelse($aniversariantesHoje as $cliente)
            <div class="an-hoje-card">
                <p class="an-hoje-card-name">{{ $cliente->nome }}</p>
                <p class="an-hoje-card-age">Completando {{ $cliente->data_nascimento->age }} anos! 🎂</p>
                <span class="an-hoje-badge">🎉 Dia de Festa!</span>
                <div class="an-hoje-deco">🎂</div>
            </div>
            @empty
            <div class="an-empty">Nenhum aniversário hoje.</div>
            @endforelse
        </div>

        {{-- Próximos do mês --}}
        <div>
            <div class="an-section-label grey">Próximos do Mês</div>
            <div class="an-card">
                <table class="an-mes-table">
                    <tbody>
                        @forelse($aniversariantesMes as $cliente)
                        <tr>
                            <td class="td-name">{{ $cliente->nome }}</td>
                            <td class="td-day">
                                <span class="an-day-chip">
                                    <span class="an-day-chip-label">Dia</span>
                                    <span class="an-day-chip-num">{{ $cliente->data_nascimento->format('d') }}</span>
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" style="padding:2.5rem 1rem;text-align:center;color:#c9a0b8;font-size:0.83rem;">
                                Sem mais aniversariantes este mês.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ── BASE GERAL ── --}}
    <div class="an-section-wrap">
        <div class="an-section-top">
            <div class="an-section-label grey" style="margin:0">Base Geral de Clientes</div>
            <span class="an-count-badge">{{ $todosClientes->count() }} cadastradas</span>
        </div>

        <div class="an-card">
            <table class="an-table">
                <thead>
                    <tr>
                        <th>Nome da Cliente</th>
                        <th class="center">Nascimento</th>
                        <th class="center">Idade</th>
                        <th class="right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todosClientes as $cliente)
                    <tr>
                        <td><span class="an-td-name">{{ $cliente->nome }}</span></td>
                        <td class="center">{{ $cliente->data_nascimento->format('d/m/Y') }}</td>
                        <td class="center">
                            <span class="an-age-chip">{{ $cliente->data_nascimento->age }} anos</span>
                        </td>
                        <td class="right">
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                  style="display:inline"
                                  onsubmit="return confirm('Deseja excluir esta cliente?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="an-del-btn" title="Excluir">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M3 6h18"/>
                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                        <line x1="10" x2="10" y1="11" y2="17"/>
                                        <line x1="14" x2="14" y1="11" y2="17"/>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="an-table-empty">Nenhuma cliente cadastrada na base.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── MODAL CADASTRO ── --}}
<div id="modalCadastro" class="an-modal-overlay">
    <div class="an-modal">
        <div class="an-modal-head">
            <div>
                <h3>Nova Cliente</h3>
                <p>Preencha os dados para cadastrar</p>
            </div>
            <button class="an-modal-close" onclick="document.getElementById('modalCadastro').classList.remove('open')" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2.5"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf
            <div class="an-modal-body">
                <div class="an-modal-field">
                    <label class="an-modal-label" for="nome">Nome completo</label>
                    <input type="text" name="nome" id="nome" required
                           class="an-modal-input" placeholder="Ex: Maria Oliveira">
                </div>
                <div class="an-modal-field">
                    <label class="an-modal-label" for="data_nascimento">Data de nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" required
                           class="an-modal-input">
                </div>
            </div>
            <div class="an-modal-foot">
                <button type="button" class="an-modal-cancel"
                        onclick="document.getElementById('modalCadastro').classList.remove('open')">
                    Cancelar
                </button>
                <button type="submit" class="an-modal-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2.5"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 6 9 17l-5-5"/>
                    </svg>
                    Salvar Cliente
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// fechar ao clicar fora do modal
document.getElementById('modalCadastro').addEventListener('click', function (e) {
    if (e.target === this) this.classList.remove('open');
});
</script>

@endsection