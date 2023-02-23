<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable=[
        'title',
        'content',
        'date',
        'status',
        'comment_status',
        'cover',
        'is_top',
        'page_views',
        'keywords',
        'description',
        'admin_id',
        'category_id',
    ];
    protected $with=['categorys','admins','tags'];

    public function admins(){
        return $this->belongsTo(Admins::class,'admin_id');
    }
    public function categorys(){
        return $this->belongsTo(Categorys::class,'category_id');
    }
    public function Tags(){
        return $this->belongsToMany(Tags::class);
    }
    public function Comments(){
        return $this->hasMany(Comments::class,'article_id');
    }
    use HasFactory;
}
