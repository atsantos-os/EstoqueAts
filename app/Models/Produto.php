<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produtos';
    protected $primaryKey = 'id_produto';
    public $timestamps = false;
    protected $fillable = [
        'codigo_produto', 'nome_produto', 'descricao_produto', 'condicao', 'tamanho', 'preco_produto', 'id_categoria', 'id_fornecedor', 'data_cadastro', 'data_atualizacao'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }

    public function estoque()
    {
        return $this->hasOne(\App\Models\Estoque::class, 'id_produto', 'id_produto');
    }
}
