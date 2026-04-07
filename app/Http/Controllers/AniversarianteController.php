<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AniversarianteController extends Controller
{
    public function index()
    {
        $hoje = \Carbon\Carbon::today();

        $aniversariantesHoje = Cliente::whereMonth('data_nascimento', $hoje->month)
            ->whereDay('data_nascimento', $hoje->day)
            ->get();

        $aniversariantesMes = Cliente::whereMonth('data_nascimento', $hoje->month)
            ->whereDay('data_nascimento', '>', $hoje->day)
            ->orderByRaw('DAY(data_nascimento) ASC')
            ->get();

        $todosClientes = Cliente::orderBy('nome')->get();

        return view('aniversarios.index', compact('aniversariantesHoje', 'aniversariantesMes', 'todosClientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
        ]);

        Cliente::create($validated);

        return redirect()->route('aniversarios.index')
            ->with('success', 'Cliente cadastrada com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente removida com sucesso.');
    }
}
