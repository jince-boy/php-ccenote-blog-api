<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_menu',
        'order',
        'front_router',
        'alias',
        'template_address',
        'back_api',
        'description',
        'icon',
        'parent_id',
        'status'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    /**
     * 这两个list方法的不同就是一个返回对象格式，一个返回数组格式
     * 2022-7-15
     * @param array $data
     * @param int $pid
     * @return array|string
     */
    public function list(array $data, int $pid = 0): array|string
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany("App\Models\Roles");
    }
}
