<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AniversarianteController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //dashboard/admin
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    //vendas
    Route::get('/vendas', [VendaController::class, 'index'])->name('vendas.index');
    Route::get('/vendas/create', [VendaController::class, 'create'])->name('vendas.create');
    Route::post('/vendas', [VendaController::class, 'store'])->name('vendas.store');
    Route::get('/vendas/{venda}', [VendaController::class, 'show'])->name('vendas.show');
    Route::patch('/vendas/{venda}/abater-parcela', [VendaController::class, 'abater'])->name('vendas.abater');
    Route::delete('/vendas/{venda}', [VendaController::class, 'destroy'])->name('vendas.excluir');
    Route::get('/vendas/{venda}/edit', [VendaController::class, 'edit'])->name('vendas.edit');
    Route::put('/vendas/{venda}', [VendaController::class, 'update'])->name('vendas.update');
    Route::post('/vendas/{venda}/adicionar-itens', [VendaController::class, 'adicionarItens'])->name('vendas.adicionar-itens');

    //notificações
    Route::get('/notificacoes', [AdminController::class, 'notificacoes'])->name('notificacoes.index');

    //parcelas
    Route::patch('/parcelas/{parcela}/pagar', [ParcelaController::class, 'pagar'])->name('parcelas.pagar');
    Route::patch('/parcelas/{parcela}/update-date', [ParcelaController::class, 'updateDate'])->name('parcelas.updateDate');
    Route::patch('/parcelas/{parcela}/recalcular', [ParcelaController::class, 'recalcular'])->name('parcelas.recalcular');

    Route::get('/aniversarios', [AniversarianteController::class, 'index'])->name('aniversarios.index');
    Route::post('/clientes', [AniversarianteController::class, 'store'])->name('clientes.store');
    Route::delete('/clientes/{cliente}', [AniversarianteController::class, 'destroy'])->name('clientes.destroy');
});

require __DIR__ . '/auth.php';
