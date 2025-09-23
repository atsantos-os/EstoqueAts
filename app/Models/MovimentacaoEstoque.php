<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    protected $table = 'movimentacoes_estoque';
    protected $primaryKey = 'id_movimentacao';
    public $timestamps = false;
    protected $fillable = [
        'id_produto', 'id_cliente', 'tipo_movimentacao', 'quantidade', 'data_solicitacao', 'data_entrega', 'retirada_por', 'observacao'
    ];
}
