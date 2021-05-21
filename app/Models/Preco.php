<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    use HasFactory;
    protected $timestamp = false;
    protected $fillable = [ 'preco_un_catalogo', 'preco_un_proprio', 'preco_un_catalogo_desconto', 'preco_un_proprio_desconto', 'quantidade_desconto'];
}
