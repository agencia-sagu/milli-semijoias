<?php

namespace Database\Seeders;

use App\Models\Venda;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VendaSeeder extends Seeder
{

    public function run(): void
    {
        $clientes = [
            'João Silva',
            'Maria Oliveira',
            'Carlos Pereira',
            'Ana Souza',
            'Pedro Santos',
            'Fernanda Lima',
            'Lucas Martins',
            'Juliana Alves',
            'Rafael Costa',
            'Camila Rocha'
        ];

        $produtos = [
            'Notebook',
            'Mouse',
            'Teclado',
            'Monitor',
            'Headset',
            'Cadeira Gamer',
            'Celular',
            'Tablet',
            'Smart TV',
            'Soundbar'
        ];

        for ($i = 0; $i < 25; $i++) {

            $qtdItens = rand(1, 4);

            $items = [];
            $prices = [];

            for ($j = 0; $j < $qtdItens; $j++) {
                $items[] = $produtos[array_rand($produtos)];
                $prices[] = rand(50, 3000);
            }

            $valorTotal = array_sum($prices);
            $parcelas = rand(1, 12);

            $venda = Venda::create([
                'cliente_nome' => $clientes[array_rand($clientes)],
                'item' => implode(', ', $items),
                'item_prices' => $prices,
                'valor_total' => $valorTotal,
                'quantidade_parcelas' => $parcelas,
                'data_venda' => now()->subDays(rand(0, 60)),
            ]);

            $valorParcela = $valorTotal / $parcelas;

            $dataBase = Carbon::now()->addDays(rand(1, 10));

            for ($p = 1; $p <= $parcelas; $p++) {
                $venda->parcelas()->create([
                    'numero_parcela' => $p,
                    'valor' => number_format($valorParcela, 2, '.', ''),
                    'data_vencimento' => $dataBase->copy()->addMonths($p - 1),
                    'pago' => rand(0, 1)
                ]);
            }
        }
    }
}
