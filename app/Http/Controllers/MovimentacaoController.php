<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\Movimentacao;

class MovimentacaoController extends Controller
{
    // Método para listar todas as movimentações
    public function store(Request $request)
    {
        $validated = $request->validate([
            'productId' => 'required|exists:produtos,id',
            'quantity' => 'required|numeric|min:1',
            'client' => 'required|exists:clientes,id',
        ]);
    
        try {
            $movimentacao = Movimentacao::create([
                'produto_id' => $validated['productId'],
                'quantidade' => $validated['quantity'],
                'cliente_id' => $validated['client'],
                'usuario_id' => auth()->id(),
            ]);
    
            // Atualizar quantidade do produto
            $produto = Produto::find($validated['productId']);
            $produto->quantidade -= $validated['quantity'];
            $produto->save();
    
            return response()->json(['success' => true, 'message' => 'Movimentação registrada com sucesso!'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erro ao registrar movimentação.'], 500);
        }
    }
    
}
