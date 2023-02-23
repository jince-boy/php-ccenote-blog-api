<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use HasFactory;

    protected $fillable=[
        'url',
        'path',
        'title'
    ];
    protected $hidden=[
      'created_at',
      'updated_at'
    ];
}
