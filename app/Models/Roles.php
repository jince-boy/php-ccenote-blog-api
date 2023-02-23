<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'description',
        'status'
    ];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
    public function Admins(){
        return $this->hasMany(Admins::class,'id');
    }

    public function Permissions(){
        return $this->belongsToMany(Permissions::class);
    }

    /**
     * 获取角色列表
     * @param array $data
     * @param int $pid
     * @return array|string
     */
    public function list(array $data,int $pid=0)
    {
        $arr=[];
        if(empty($data)){
            return "";
        }
        foreach($data as $value){
            if($value['parent_id']==$pid){
                $value['children']=self::list($data,$value['id']);
                $arr[]=$value;
            }
        }
        return $arr;
    }
}
