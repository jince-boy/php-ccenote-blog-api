<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorys extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_menu',
        'order',
        'icon',
        'parent_id'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function Article()
    {
        return $this->hasMany(Articles::class,'category_id');
    }

    /**
     * 递归获取分类列表
     * @param array $data
     * @param int $pid
     * @return array|string
     */
    public function list(array $data, int $pid = 0)
    {
        $arr = [];
        if (empty($data)) {
            return "";
        }
        foreach ($data as $value) {
            if ($value['parent_id'] == $pid) {
                $value['children'] = self::list($data, $value['id']);
                $arr[] = $value;
            }
        }
        return $arr;
    }
    use HasFactory;
}
