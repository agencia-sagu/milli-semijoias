<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    protected $table = 'parcelas';

    protected $fillable = [
        'venda_id',
        'numero_parcela',
        'valor',
        'data_vencimento',
        'pago'
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'pago' => 'boolean'
    ];

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    public function getStatusAttribute()
    {
        if ($this->pago) return 'pago';
        if ($this->data_vencimento < now()->startOfDay()) return 'atrasado';
        return 'pendente';
    }

    public function getDiasAtrasoAttribute()
    {
        $hoje = now()->startOfDay();
        $vencimento = $this->data_vencimento->startOfDay();

        if (!$this->pago && $vencimento < $hoje) {
            return (int) $hoje->diffInDays($vencimento);
        }

        return 0;
    }
}
