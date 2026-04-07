<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\Venda;

class AdminController extends Controller
{
    public function dashboard()
    {
        $hoje = now();
        $inicioHoje = now()->startOfDay();
        $fimHoje = now()->endOfDay();
        $proximos7Dias = now()->addDays(7)->endOfDay();
        $vendasHojeQuery = Venda::whereBetween('created_at', [$inicioHoje, $fimHoje]);
        $vendasHoje = $vendasHojeQuery->count();
        $valorVendasHoje = $vendasHojeQuery->sum('valor_total');
        $parcelasPendentesQuery = Parcela::where('pago', false);
        $valorPendente = $parcelasPendentesQuery->sum('valor');
        $parcelasPendentes = $parcelasPendentesQuery->count();

        $parcelasAtrasadasQuery = Parcela::where('pago', false)
            ->where('data_vencimento', '<', $inicioHoje);

        $valorAtrasado = $parcelasAtrasadasQuery->sum('valor');
        $pagamentoAtrasado = $parcelasAtrasadasQuery->count();

        $atrasado = Venda::whereHas('parcelas', function ($q) use ($inicioHoje) {
            $q->where('pago', false)
                ->where('data_vencimento', '<', $inicioHoje);
        })
            ->with(['parcelas' => function ($q) use ($inicioHoje) {
                $q->where('pago', false)
                    ->where('data_vencimento', '<', $inicioHoje);
            }])
            ->get();

        $venceHoje = Parcela::where('pago', false)
            ->whereBetween('data_vencimento', [$inicioHoje, $fimHoje])
            ->count();

        $vencendoEmBreve = Parcela::where('pago', false)
            ->whereBetween('data_vencimento', [
                now()->addDay()->startOfDay(),
                $proximos7Dias
            ])
            ->with('venda')
            ->orderBy('data_vencimento', 'asc')
            ->get();

        return view('dashboard', compact(
            'vendasHoje',
            'valorVendasHoje',
            'valorPendente',
            'parcelasPendentes',
            'valorAtrasado',
            'venceHoje',
            'pagamentoAtrasado',
            'atrasado',
            'vencendoEmBreve'
        ));
    }
}
