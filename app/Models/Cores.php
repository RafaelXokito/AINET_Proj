<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cores extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $incrementing = false;
    protected $fillable = [ 'codigo', 'nome'];
}
