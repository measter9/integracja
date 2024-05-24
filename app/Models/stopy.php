<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stopy extends Model
{
    use HasFactory;
    protected $table = 'stopy';

    protected $fillable = [
        'data',
        'ref',
        'lom',
        'dep',
        'red',
        'dys'
    ];

//    protected function casts(): array
//    {
//        return [
//            'data' => 'datetime'
//        ];
//    }
}
