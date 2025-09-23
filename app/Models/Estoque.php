<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    protected $table = 'estoque';
    protected $primaryKey = 'id_estoque';
    public $timestamps = false;
    protected $fillable = ['id_produto', 'quantidade'];
}
