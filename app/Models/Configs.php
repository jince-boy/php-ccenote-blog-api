<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configs extends Model
{

    use HasFactory;

    protected $fillable=[
        'title',
        'description',
        'keywords',
        'logo',
        'is_register',
        'site_status',
        'close_reason',
        'copyright',
        'record',
        'edition',
        'front_page_num',
        'back_page_num',
        'contact',
        'notice',
        'grey'
    ];
    protected $hidden=[
        'id',
        'created_at',
        'updated_at'
    ];
}
