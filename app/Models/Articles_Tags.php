<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles_Tags extends Model
{
    use HasFactory;
    protected $fillable=[
        'articles_id',
        'tabs_id'
    ];
}
