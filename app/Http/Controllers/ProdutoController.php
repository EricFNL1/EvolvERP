<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\HistoricoMovimentacao;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller {
    
    public function index() {
        return response()->json(Produto::all());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1',
            'unidade' => 'required|string|in:KG,Sacos',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto = Produto::create($validated);

        HistoricoMovimentacao::create([
            'produto_id' => $produto->id,
            'quantidade' => $request->quantidade,
            'unidade' => $request->unidade,
            'acao' => 'Adicionado',
            'usuario_id' => Auth::id(),
        ]);

        return response()->json($produto, 201);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'quantidade' => 'required|integer|min:1',
            'unidade' => 'required|string|in:KG,Sacos',
            'preco' => 'required|numeric|min:0',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->update($validated);

        HistoricoMovimentacao::create([
            'produto_id' => $produto->id,
            'quantidade' => $request->quantidade,
            'unidade' => $request->unidade,
            'acao' => 'Editado',
            'usuario_id' => Auth::id(),
        ]);

        return response()->json($produto);
    }

    public function destroy($id) {
        $produto = Produto::findOrFail($id);
        $unidade = $produto->unidade;
        $produto->delete();

        HistoricoMovimentacao::create([
            'produto_id' => $id,
            'quantidade' => 0,
            'unidade' => $unidade,
            'acao' => 'Excluído',
            'usuario_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Produto excluído com sucesso']);
    }

    public function historico($id) {
        $historico = HistoricoMovimentacao::where('produto_id', $id)
            ->with('usuario')
            ->orderBy('created_at', 'asc') // Ordenar por data mais antiga primeiro
            ->get();
    
        return response()->json($historico);
    }
    

    public function historicoGeral(Request $request) {
        // Validação opcional de datas
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        // Obter os filtros de data
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Query para buscar o histórico, filtrando por datas, se fornecidas
        $query = HistoricoMovimentacao::with('usuario');
    
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
    
        $historico = $query->get();
    
        return response()->json($historico);
    }
    
    
    
}
