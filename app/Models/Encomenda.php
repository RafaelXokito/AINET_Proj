<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomenda extends Model
{
    use HasFactory;
    protected $fillable = [ 'estado', 'cliente_id', 'data', 'preco_total', 'notas', 'nif', 'endereco', 'tipo_pagamento', 'ref_pagamento', 'recibo_url'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id')->withTrashed();
    }

}
