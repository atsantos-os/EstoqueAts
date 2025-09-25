<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maquinario;

class MaquinarioController extends Controller
{
    public function index()
    {
        $maquinarios = Maquinario::with(['fornecedor', 'cliente'])->get();
        // Não passar $usuario explicitamente, deixar Laravel usar o escopo global
        return view('maquinarios', compact('maquinarios'));
    }

    public function create()
    {
    return redirect()->route('maquinarios.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'maquina' => 'required|max:100',
            'marca' => 'required|max:50',
            'modelo' => 'required|max:50',
            'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'supervisor' => 'required',
            'cor' => 'nullable|max:30',
            'patrimonio' => 'required|max:50|unique:maquinarios,patrimonio',
            'valor' => 'nullable|numeric',
            'contrato' => 'nullable|max:50',
            'local' => 'nullable|max:100',
            'volts' => 'nullable|max:20',
            'conferencia' => 'nullable|max:100',
            'observacao' => 'nullable',
            'data_saida' => 'nullable|date',
        ]);
        Maquinario::create($validated);
        return redirect()->route('maquinarios.index')->with('success', 'Maquinário cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $maquinario = Maquinario::findOrFail($id);
        return redirect()->route('maquinarios.index');
    }

    public function update(Request $request, $id)
    {
        $maquinario = Maquinario::findOrFail($id);
        $validated = $request->validate([
            'maquina' => 'required|max:100',
            'marca' => 'required|max:50',
            'modelo' => 'required|max:50',
            'id_fornecedor' => 'nullable|exists:fornecedores,id_fornecedor',
            'id_cliente' => 'nullable|exists:clientes,id_cliente',
            'supervisor' => 'required',
            'cor' => 'nullable|max:30',
            'patrimonio' => 'required|max:50|unique:maquinarios,patrimonio,' . $id . ',id_maquinario',
            'valor' => 'nullable|numeric',
            'contrato' => 'nullable|max:50',
            'local' => 'nullable|max:100',
            'volts' => 'nullable|max:20',
            'conferencia' => 'nullable|max:100',
            'observacao' => 'nullable',
            'data_saida' => 'nullable|date',
        ]);
        $maquinario->update($validated);
        return redirect()->route('maquinarios.index')->with('success', 'Maquinário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $maquinario = Maquinario::findOrFail($id);
        $maquinario->delete();
        return redirect()->route('maquinarios.index')->with('success', 'Maquinário removido com sucesso!');
    }
}
