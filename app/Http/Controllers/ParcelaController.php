<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParcelaController extends Controller
{
    public function pagar(Parcela $parcela)
    {
        $parcela->update([
            'pago' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parcela paga com sucesso.',
            'parcela' => $parcela->id,
        ]);
    }

    public function updateDate(Request $request, Parcela $parcela)
    {
        $request->validate([
            'data_vencimento' => 'required|date',
        ]);

        $parcela->update([
            'data_vencimento' => $request->data_vencimento
        ]);

        return response()->json([
            'success' => true,
            'nova_data' => $parcela->data_vencimento->format('d/m/Y'),
            'status' => $parcela->status
        ]);
    }

    public function togglePagamento($id)
    {
        $parcela = Parcela::findOrFail($id);
        $parcela->pago = !$parcela->pago;
        $parcela->save();

        return response()->json([
            'success' => true,
            'is_pago' => $parcela->pago
        ]);
    }

    public function recalcular(Request $request, Parcela $parcela)
    {
        $request->validate(['valor' => 'required|numeric|min:0']);

        $venda = $parcela->venda;
        $novoValor = (float) $request->valor;

        return DB::transaction(function () use ($venda, $parcela, $novoValor) {
            $parcela->update(['valor' => $novoValor]);

            $parcelasRestantes = $venda->parcelas()
                ->where('pago', false)
                ->where('id', '!=', $parcela->id)
                ->orderBy('numero_parcela', 'asc')
                ->get();

            if ($parcelasRestantes->count() > 0) {
                $totalJaDefinido = $venda->parcelas()->where('pago', true)->sum('valor') + $novoValor;
                $saldoParaDistribuir = $venda->valor_total - $totalJaDefinido;

                $valorPorParcela = floor(($saldoParaDistribuir / $parcelasRestantes->count()) * 100) / 100;

                foreach ($parcelasRestantes as $index => $p) {
                    if ($index === $parcelasRestantes->count() - 1) {
                        $p->update(['valor' => max(0, $saldoParaDistribuir)]);
                    } else {
                        $p->update(['valor' => max(0, $valorPorParcela)]);
                        $saldoParaDistribuir -= $valorPorParcela;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Parcelas recalculadas com sucesso!'
            ]);
        });
    }
}
