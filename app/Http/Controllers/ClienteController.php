<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cnpj' => 'required|string|max:18|unique:clientes,cnpj',
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'contrato' => 'nullable|string|max:100',
            'supervisor' => 'nullable|string|max:100',
        ]);
        Cliente::create($validated);
        return redirect()->route('clientes')->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $validated = $request->validate([
            'cnpj' => 'required|string|max:18|unique:clientes,cnpj,' . $id . ',id_cliente',
            'razao_social' => 'required|string|max:255',
            'nome_fantasia' => 'nullable|string|max:255',
            'contrato' => 'nullable|string|max:100',
            'supervisor' => 'nullable|string|max:100',
        ]);
        $cliente->update($validated);
        return redirect()->route('clientes')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return redirect()->route('clientes')->with('success', 'Cliente excluído com sucesso!');
    }
}
