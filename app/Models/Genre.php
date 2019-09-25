<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Genre extends Model
{
    // Instancia o softdeletes
    use SoftDeletes, Traits\Uuid;

    protected $fillable = ['name', 'is_active'];

    // Especifica o campo como data
    protected $dates = ['deleted_at'];

    // Especifica o tipo do campo para o Uuid
    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean'
    ];

    // Desabilita o id incremental
    public $incrementing = false;
    
}
