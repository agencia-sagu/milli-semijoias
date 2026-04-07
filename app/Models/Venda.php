<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [
        'cliente_nome',
        'cpf',
        'item',
        'item_prices',
        'valor_total',
        'quantidade_parcelas',
        'data_venda',
        'is_flexivel',
    ];

    protected $casts = [
        'data_venda' => 'date',
        'item_prices' => 'array',
        'is_flexivel' => 'boolean',
    ];

    public function parcelas()
    {
        return $this->hasMany(Parcela::class);
    }

    public function proximaParcela()
    {
        return $this->hasOne(Parcela::class)
            ->where('pago', false)
            ->orderBy('data_vencimento', 'asc');
    }

    public function getStatusGeralAttribute()
    {
        $parcelas = $this->parcelas;

        if ($parcelas->isEmpty()) return 'pendente';

        if ($parcelas->where('pago', false)->count() === 0) {
            return 'pago';
        }

        $temAtrasada = $parcelas->contains(function ($parcela) {
            return !$parcela->pago && $parcela->data_vencimento < now()->startOfDay();
        });

        return $temAtrasada ? 'atrasado' : 'pendente';
    }
}
