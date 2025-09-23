<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = 'movimentacoes_estoque';
    protected $primaryKey = 'id_movimentacao';
    public $timestamps = false;
    protected $fillable = [
        'id_produto', 'tipo_movimentacao', 'quantidade', 'data_solicitacao', 'retirada_por'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id_produto');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\modelUsuario::class, 'retirada_por', 'id');
    }
}
