<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [ 'id', 'nif', 'endereco', 'tipo_pagamento', 'ref_pagamento'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
