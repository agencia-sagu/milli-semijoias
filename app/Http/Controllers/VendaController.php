<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venda::with(['parcelas', 'proximaParcela']);

        if ($request->has('status')) {
            if ($request->status === 'atrasado') {
                $query->whereHas('parcelas', function ($q) {
                    $q->where('pago', false)->where('data_vencimento', '<', now()->startOfDay());
                });
            } elseif ($request->status === 'pago') {
                $query->whereDoesntHave('parcelas', function ($q) {
                    $q->where('pago', false);
                });
            } elseif ($request->status === 'pendente') {
                $query->whereHas('parcelas', function ($q) {
                    $q->where('pago', false)->where('data_vencimento', '>=', now()->startOfDay());
                });
            }
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('cliente_nome', 'like', '%' . $request->q . '%')
                    ->orWhere('item', 'like', '%' . $request->q . '%');
            });
        }

        $vendas = $query->orderBy('cliente_nome')->paginate(10)->withQueryString();

        return view('vendas.index', compact('vendas'));
    }

    public function create()
    {
        return view('vendas.create');
    }

    public function store(Request $request)
    {
        $isFlexivel = $request->has('is_flexivel');

        $rules = [
            'cliente_nome' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:14',
            'items' => 'required|array|min:1',
            'item_prices' => 'required|array|min:1',
            'quantidade_parcelas' => 'required|integer|min:1',
            'is_flexivel' => 'boolean',
        ];

        if (!$isFlexivel) {
            $rules['data_vencimento'] = 'required|date';
        }

        $validated = $request->validate($rules);

        $valorTotalReal = array_sum($request->item_prices);

        return DB::transaction(function () use ($request, $validated, $valorTotalReal, $isFlexivel) {

            $venda = Venda::create([
                'cliente_nome'       => $validated['cliente_nome'],
                'cpf'                => $validated['cpf'] ?? null,
                'item'               => implode(', ', $request->items),
                'item_prices'        => $request->item_prices,
                'valor_total'        => $valorTotalReal,
                'quantidade_parcelas' => $validated['quantidade_parcelas'],
                'is_flexivel'        => $isFlexivel,
                'data_venda'         => now(),
            ]);

            if ($isFlexivel) {
                $venda->parcelas()->create([
                    'numero_parcela'  => 1,
                    'valor'           => $valorTotalReal,
                    'data_vencimento' => null,
                    'pago'            => false,
                ]);
            } else {
                $qtdParcelas = (int) $validated['quantidade_parcelas'];
                $totalEmCentavos = (int) round($valorTotalReal * 100);
                $valorParcelaComumCentavos = (int) floor($totalEmCentavos / $qtdParcelas);
                $somaDasAnterioresCentavos = $valorParcelaComumCentavos * ($qtdParcelas - 1);
                $valorUltimaParcelaCentavos = $totalEmCentavos - $somaDasAnterioresCentavos;
                $dataVencimentoBase = Carbon::parse($validated['data_vencimento']);

                for ($i = 1; $i <= $qtdParcelas; $i++) {
                    $valorCentavosParaGravar = ($i === $qtdParcelas)
                        ? $valorUltimaParcelaCentavos
                        : $valorParcelaComumCentavos;

                    $valorFinal = $valorCentavosParaGravar / 100;

                    $venda->parcelas()->create([
                        'numero_parcela'  => $i,
                        'valor'           => number_format($valorFinal, 2, '.', ''),
                        'data_vencimento' => $dataVencimentoBase->copy()->addMonths($i - 1),
                        'pago'            => false,
                    ]);
                }
            }


            return redirect()->route('vendas.index')
                ->with('success', "Venda registrada com sucesso!");
        });
    }

    public function show(Venda $venda)
    {
        $venda->load(['parcelas' => function ($query) {
            $query->orderBy('numero_parcela', 'asc');
        }]);

        return view('vendas.show', compact('venda'));
    }

    public function abater(Request $request, Venda $venda)
    {
        $request->validate(['valor_abatido' => 'required|numeric|min:0.01']);
        $valorPago = $request->valor_abatido;

        return DB::transaction(function () use ($venda, $valorPago) {

            $saldoOriginal = $venda->parcelas()->where('pago', false)->first();

            if ($saldoOriginal) {
                $novoValorSaldo = $saldoOriginal->valor - $valorPago;

                $venda->parcelas()->create([
                    'numero_parcela' => $venda->parcelas()->count() + 1,
                    'valor' => $valorPago,
                    'data_vencimento' => now(),
                    'pago' => true,
                ]);

                if ($novoValorSaldo <= 0.01) {
                    $saldoOriginal->delete();
                } else {
                    $saldoOriginal->update(['valor' => $novoValorSaldo]);
                }
            }

            return back()->with('success', 'Valor abatido e registrado no histórico!');
        });
    }

    public function destroy($id)
    {
        $venda = Venda::findOrFail($id);
        $venda->delete();
        return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso.');
    }

    public function edit(Venda $venda)
    {
        return view('vendas.edit', compact('venda'));
    }

    public function update(Request $request, Venda $venda)
    {
        $isFlexivel = $request->has('is_flexivel');

        $rules = [
            'cliente_nome'        => 'required|string|max:255',
            'cpf' => 'nullable|string|size:14',
            'items'               => 'required|array|min:1',
            'item_prices'         => 'required|array|min:1',
            'quantidade_parcelas' => 'required|integer|min:1',
        ];

        if (!$isFlexivel) {
            $rules['data_vencimento'] = 'required|date';
        }

        $validated = $request->validate($rules);

        $valorTotalReal = array_sum($request->item_prices);

        return DB::transaction(function () use ($request, $validated, $valorTotalReal, $isFlexivel, $venda) {

            $venda->update([
                'cliente_nome'        => $validated['cliente_nome'],
                'cpf'                 => $validated['cpf'] ?? null,
                'item'                => implode(', ', $request->items),
                'item_prices'         => $request->item_prices,
                'valor_total'         => $valorTotalReal,
                'quantidade_parcelas' => $validated['quantidade_parcelas'],
                'is_flexivel'         => $isFlexivel,
            ]);

            $venda->parcelas()->delete();

            if ($isFlexivel) {
                $venda->parcelas()->create([
                    'numero_parcela'  => 1,
                    'valor'           => $valorTotalReal,
                    'data_vencimento' => null,
                    'pago'            => false,
                ]);
            } else {
                $qtdParcelas = (int) $validated['quantidade_parcelas'];
                $totalEmCentavos = (int) round($valorTotalReal * 100);
                $valorParcelaComumCentavos = (int) floor($totalEmCentavos / $qtdParcelas);
                $somaDasAnterioresCentavos = $valorParcelaComumCentavos * ($qtdParcelas - 1);
                $valorUltimaParcelaCentavos = $totalEmCentavos - $somaDasAnterioresCentavos;
                $dataVencimentoBase = Carbon::parse($validated['data_vencimento']);

                for ($i = 1; $i <= $qtdParcelas; $i++) {
                    $valorCentavos = ($i === $qtdParcelas)
                        ? $valorUltimaParcelaCentavos
                        : $valorParcelaComumCentavos;

                    $venda->parcelas()->create([
                        'numero_parcela'  => $i,
                        'valor'           => number_format($valorCentavos / 100, 2, '.', ''),
                        'data_vencimento' => $dataVencimentoBase->copy()->addMonths($i - 1),
                        'pago'            => false,
                    ]);
                }
            }

            return redirect()->route('vendas.index')
                ->with('success', 'Venda atualizada com sucesso!');
        });
    }

    public function adicionarItens(Request $request, Venda $venda)
    {
        $request->validate([
            'novos_items' => 'required|array|min:1',
            'novos_item_prices' => 'required|array|min:1',
        ]);

        return DB::transaction(function () use ($request, $venda) {
            $valorNovosItens = array_sum($request->novos_item_prices);

            $itensAtuais = explode(', ', $venda->item);
            $precosAtuais = is_array($venda->item_prices) ? $venda->item_prices : json_decode($venda->item_prices, true) ?? [];

            $novosItensLista = array_merge($itensAtuais, $request->novos_items);
            $novosPrecosLista = array_merge($precosAtuais, $request->novos_item_prices);

            $venda->update([
                'item' => implode(', ', $novosItensLista),
                'item_prices' => $novosPrecosLista,
                'valor_total' => $venda->valor_total + $valorNovosItens
            ]);

            $parcelasAbertas = $venda->parcelas()
                ->where('pago', false)
                ->orderBy('numero_parcela', 'asc')
                ->get();

            $totalParcelasAbertas = $parcelasAbertas->count();

            if ($totalParcelasAbertas > 0) {
                $valorPorParcela = $valorNovosItens / $totalParcelasAbertas;

                foreach ($parcelasAbertas as $parcela) {
                    $parcela->update([
                        'valor' => $parcela->valor + $valorPorParcela
                    ]);
                }
            } else {
                $venda->parcelas()->create([
                    'numero_parcela' => $venda->parcelas()->max('numero_parcela') + 1,
                    'valor' => $valorNovosItens,
                    'data_vencimento' => now()->addMonth(), 
                    'pago' => false,
                ]);
            }

            return back()->with('success', 'Itens adicionados e valores diluídos nas parcelas restantes!');
        });
    }
}
