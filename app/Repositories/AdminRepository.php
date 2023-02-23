<?php

namespace App\Repositories;

use App\Models\Admins;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends BaseRepository
{
    public function __construct(Admins $model)
    {
        parent::__construct($model);
    }


    /**
     * 管理员列表数据
     * 2022-7-19
     */
    public function getAdminList()
    {
        $paginator = $this->backPage();
        $data = $paginator->makeHidden(['password', 'token', 'created_at', 'updated_at', 'roles', 'role_id'])->map(function ($contact) {
            $contact->role = $contact->roles->name;
            $contact->create_time = $contact->created_at->format('Y-m-d');
            return $contact;
        });
        $paginator->data = $data;
        return $paginator;
    }

    /**
     * 管理员信息
     * 2022-7-19
     */
    public function getUserData($id)
    {
        return tap($this->model::where('id', $id)->with('roles:id,name')->first()->makeHidden(['password', 'token', 'created_at', 'updated_at', 'role_id', 'roles']), function ($contact) {
            $contact->role = $contact->roles;
            return $contact;
        });
    }

    /**
     * 管理员添加
     * 2022-7-19
     */
    public function add($request)
    {
        return $this->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'url' => $request->url,
            'profile' => $request->profile,
            'avatar' => asset('images/avatar/avatar.jpg'),
            'role_id' => $request->role_id,
            'status' => $request->status
        ]);
    }

    /**
     * 模糊搜索获取用户id
     * @param $username
     * @return array
     */
    public function getAdminId($username): array
    {
       $user=$this->model::where('username','like','%'.$username.'%')->select('id')->get();
        $data=[];
        foreach ($user as $value){
            $data[]=$value->id;
        }
        return $data;
    }
}
