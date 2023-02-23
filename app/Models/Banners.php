<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    use HasFactory;

    protected $fillable=[
      'path',
      'description',
      'url'
    ];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
}
