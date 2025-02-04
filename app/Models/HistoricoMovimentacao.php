<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoMovimentacao extends Model {
    use HasFactory;

    protected $fillable = ['produto_id', 'quantidade', 'unidade', 'acao', 'usuario_id'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
    
    
}
