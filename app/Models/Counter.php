<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model;

class Counter extends Model
{
    protected $collection = 'counters'; // Nombre de la colección en MongoDB
    protected $fillable = [
        'collectionName',    // Nombre de la colección (p. ej., 'users')
        'sequence',     // Valor del contador
    ];
}
