<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;

class ProdutoController extends Controller
{
    public function index()
    {
        return response()->json(Produto::all());
    }
    

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0.01',
        ]);
    
        $produto = Produto::create($validated);
        return response()->json($produto, 201);
    }
    

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1',
            'preco' => 'required|numeric|min:0.01',
        ]);
    
        $produto = Produto::findOrFail($id);
        $produto->update($validated);
    
        return response()->json($produto);
    }
    

    public function destroy($id)
{
    $produto = Produto::findOrFail($id);
    $produto->delete();

    return response()->json(['message' => 'Produto excluído com sucesso!']);
}

}
