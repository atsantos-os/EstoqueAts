<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManutencaoMaquinario extends Model
{
    protected $table = 'manutencao_maquinario';
    protected $primaryKey = 'id_manutencao';
    public $timestamps = true;
    protected $fillable = [
        'maquinario_id', 'data_abertura', 'defeito', 'id_fornecedor', 'orcamento', 'valor_nf', 'data_vencimento'
    ];

    public function maquinario() {
        return $this->belongsTo(Maquinario::class, 'maquinario_id', 'id_maquinario');
    }
    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }
}
