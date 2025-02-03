<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;

class EstoqueController extends Controller
{
    public function index()
    {
        $items = Estoque::all(); // Obtem todos os itens do estoque
        return view('estoque', compact('items'));
    }

    public function create()
    {
        return view('estoque-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        Estoque::create($request->all());

        return redirect()->route('estoque.index')->with('success', 'Item adicionado com sucesso!');
    }

    public function edit($id)
    {
        $item = Estoque::findOrFail($id);
        return view('estoque-edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $item = Estoque::findOrFail($id);
        $item->update($request->all());

        return redirect()->route('estoque.index')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = Estoque::findOrFail($id);
        $item->delete();

        return redirect()->route('estoque.index')->with('success', 'Item excluído com sucesso!');
    }
}
