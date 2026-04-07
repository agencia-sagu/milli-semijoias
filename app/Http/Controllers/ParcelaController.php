<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\Venda;
use Illuminate\Http\Request;

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
}
