<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Estampa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [ 'cliente_id', 'categoria_id', 'nome', 'descricao', 'imagem_url', 'informacao_extra'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'id');
    }
}
