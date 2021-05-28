<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cores extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $fillable = [ 'codigo', 'nome'];
}
