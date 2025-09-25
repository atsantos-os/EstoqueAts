<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maquinario extends Model
{
    protected $table = 'maquinarios';
    protected $primaryKey = 'id_maquinario';
    public $timestamps = true;
    protected $fillable = [
        'maquina', 'marca', 'modelo', 'id_fornecedor', 'id_cliente', 'supervisor',
        'cor', 'patrimonio', 'valor', 'contrato', 'local', 'volts', 'conferencia',
        'observacao', 'data_saida'
    ];

    public function fornecedor() {
        return $this->belongsTo(Fornecedor::class, 'id_fornecedor', 'id_fornecedor');
    }
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
    public function manutencoes() {
        return $this->hasMany(ManutencaoMaquinario::class, 'maquinario_id', 'id_maquinario');
    }
}
