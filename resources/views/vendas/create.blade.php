@extends('layouts.app')

@section('content')
<div class="p-4 lg:p-8">
    <div class="max-w-3xl mx-auto space-y-6">

        <div class="flex items-center gap-4">
            <a href="/" class="p-2 hover:bg-white hover:shadow-sm border border-transparent hover:border-slate-200 rounded-xl transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-slate-600">
                    <path d="m12 19-7-7 7-7"></path>
                    <path d="M19 12H5"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Registrar Nova Venda</h1>
                <p class="text-slate-600 mt-1">Configure os detalhes do pagamento e prazos</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('vendas.store') }}" method="POST" class="p-6 lg:p-8 space-y-8">
                @csrf

                <div class="space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
                        <h2 class="font-semibold text-slate-800">Dados do Cliente</h2>
                    </div>

                    <div>
                        <label for="customerName" class="block text-sm font-medium text-slate-700 mb-2">Cliente</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                            <input type="text" name="cliente_nome" id="customerName"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                placeholder="Nome completo do cliente" required>
                        </div>
                    </div>

                    <div>
                        <label for="cpf" class="block text-sm font-medium text-slate-700 mb-2">CPF</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="20" height="20" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                    <path d="M7 9h.01" />
                                    <path d="M11 9h6" />
                                    <path d="M7 13h10" />
                                </svg>
                            </span>
                            <input type="text" name="cpf" id="cpf"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all"
                                placeholder="CPF do cliente">
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                            <h2 class="font-semibold text-slate-800">Itens / Peças</h2>
                        </div>
                        <button type="button" id="add-item" class="flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-100 hover:bg-indigo-100 transition-all text-sm font-bold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5v14"></path>
                            </svg>
                            Adicionar Item
                        </button>
                    </div>

                    <div id="items-container" class="space-y-3">
                        <div class="item-row relative group flex items-center gap-3 animate-in fade-in duration-300">
                            <div class="relative flex-[2]">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path>
                                        <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                        <path d="M2 7h20"></path>
                                    </svg>
                                </span>
                                <input type="text" name="items[]" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="Nome da peça" required>
                            </div>

                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-sm font-bold">R$</span>
                                <input type="number" name="item_prices[]" step="0.01" class="item-price w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-semibold" placeholder="0,00" required>
                            </div>

                            <div class="w-10"></div>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-100">
                        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                        <h2 class="font-semibold text-slate-800">Financeiro</h2>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-xl border border-slate-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-white rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-indigo-600">
                                        <path d="M20 12V8H4v4"></path>
                                        <path d="M2 12h20"></path>
                                        <path d="M20 12v8H4v-8"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Pagamento Flexível</p>
                                    <p class="text-xs text-slate-500">O cliente paga valores variados em datas diversas.</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_flexivel" id="is_flexivel" value="1" class="sr-only peer">
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Valor Total</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-blue-600 font-bold text-sm">R$</span>
                                <input type="number" name="valor_total" id="amount" step="0.01" class="w-full pl-10 pr-4 py-2.5 rounded-xl border-none bg-blue-50 text-blue-700 font-black text-lg outline-none" placeholder="0,00" readonly>
                            </div>
                        </div>

                        <div id="container-parcelas" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="installments" class="block text-sm font-medium text-slate-700 mb-2">Parcelas</label>
                                <select name="quantidade_parcelas" id="installments" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 outline-none transition-all appearance-none bg-white">
                                    <option value="1">1x (À vista)</option>
                                    <option value="2">2x</option>
                                    <option value="3">3x</option>
                                    <option value="4">4x</option>
                                    <option value="5">5x</option>
                                    <option value="6">6x</option>
                                    <option value="7">7x</option>
                                    <option value="8">8x</option>
                                    <option value="9">9x</option>
                                    <option value="10">10x</option>
                                    <option value="11">11x</option>
                                    <option value="12">12x</option>
                                </select>
                            </div>

                            <div>
                                <label for="paymentDate" class="block text-sm font-medium text-slate-700 mb-2">1º Vencimento</label>
                                <input type="date" name="data_vencimento" id="paymentDate" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 outline-none" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-slate-100">
                    <button type="submit" class="flex-1 bg-violet-400 text-white px-6 py-3.5 rounded-xl hover:bg-violet-700 active:scale-[0.98] transition-all flex items-center justify-center gap-2 font-bold shadow-lg shadow-violet-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Confirmar Venda
                    </button>
                    <a href="{{ route('vendas.index') }}" class="px-6 py-3.5 bg-red-400 border border-slate-200 rounded-xl hover:bg-red-500 text-white font-semibold text-center transition-all">
                        Descartar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const checkFlexivel = document.getElementById('is_flexivel');
    const containerParcelas = document.getElementById('container-parcelas');
    const inputDataVenc = document.getElementById('paymentDate');

    checkFlexivel.addEventListener('change', function() {
        if (this.checked) {
            containerParcelas.style.display = 'none';
            inputDataVenc.required = false;
        } else {
            containerParcelas.style.display = 'grid';
            inputDataVenc.required = true;
        }
    });
</script>

<script>
    const container = document.getElementById('items-container');
    const totalInput = document.getElementById('amount');

    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.item-price').forEach(input => {
            const val = parseFloat(input.value) || 0;
            total += val;
        });
        totalInput.value = total.toFixed(2);
    }

    container.addEventListener('input', function(e) {
        if (e.target.classList.contains('item-price')) {
            calculateTotal();
        }
    });

    document.getElementById('add-item').addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'item-row relative group flex items-center gap-3 animate-in slide-in-from-top-2 duration-200';

        newItem.innerHTML = `
            <div class="relative flex-[2]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"></path><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><path d="M2 7h20"></path></svg>
                </span>
                <input type="text" name="items[]" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all" placeholder="Outro item..." required>
            </div>
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400 text-sm font-bold">R$</span>
                <input type="number" name="item_prices[]" step="0.01" class="item-price w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-semibold" placeholder="0,00" required>
            </div>
            <button type="button" class="remove-item p-2.5 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all" title="Remover item">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
            </button>
        `;

        container.appendChild(newItem);
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item')) {
            e.target.closest('.item-row').remove();
            calculateTotal();
        }
    });
</script>
<script>
    document.getElementById('cpf').addEventListener('input', function (e) {
        let v = e.target.value.replace(/\D/g, '').slice(0, 11);
        if (v.length > 9) v = v.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        else if (v.length > 6) v = v.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        else if (v.length > 3) v = v.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        e.target.value = v;
    });
</script>
@endsection