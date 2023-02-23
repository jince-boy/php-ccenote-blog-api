<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'article_id',
        'content',
        'parent_id',
        'user_mark'
    ];
    protected $hidden=[
        'created_id',
        'update_id',
    ];
    protected $with=['articles','users','admins'];

    public function Users(){
        return $this->belongsTo(Users::class,'user_id');
    }
    public function Admins(){
        return $this->belongsTo(Admins::class,'user_id');
    }
    public function Articles(){
        return $this->belongsTo(Articles::class,"article_id");
    }
    public function parents(){
        return $this->hasMany(Comments::class,'parent_id','id');
    }

    /**
     * 递归获取评论列表
     * @param array $data
     * @param int $pid
     * @return array|string
     */
    public function List(array $data,int $pid=0){
        $arr=[];
        if(empty($data)){
            return "";
        }
        foreach ($data as $value) {
            if($value['parent_id']==$pid){
                $value['children']=self::List($data,$value['id']);
                $arr[]=$value;
            }
        }
        return $arr;
    }

}
