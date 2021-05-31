<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cor extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $incrementing = false;
    public $timestamps = false;
    public $table = 'cores';
    protected $key_Type = 'string';
    protected $primaryKey = 'codigo';
    protected $fillable = [ 'codigo', 'nome'];
}
