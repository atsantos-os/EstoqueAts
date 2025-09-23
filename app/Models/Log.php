<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'id_usuario', 'acao', 'detalhes', 'ip'
    ];
    public function usuario()
    {
        return $this->belongsTo(modelUsuario::class, 'id_usuario', 'id');
    }
}
