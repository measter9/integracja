<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prices extends Model
{
    use HasFactory;
    protected $table = 'price';
    protected $hidden = [
        'id',
    ];
    protected $fillable = [
        'kategoria',
        'kwartal',
        'miasto',
        'cena'
    ];
}
