<?php

namespace App\Repositories;


use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{

    public function __construct(Users $model)
    {
        parent::__construct($model);
    }

    /**
     * 用户注册
     * @param $request
     * @return mixed
     */
    public function register($request)
    {
        return $this->create([
            'username' => $request->username,
            'name' => '普通用户',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => asset('images/avatar/avatar.jpg')
        ]);
    }

    /**
     * 获取用户列表
     * 2022-9-1
     * @return mixed
     */
    public function getUserList(): mixed
    {
        $paginator = $this->backPage();
        $data = $paginator->makeHidden(['password', 'token', 'created_at', 'updated_at'])->map(function ($contact) {
            $contact->create_time = $contact->created_at->format('Y-m-d');
            return $contact;
        });
        $paginator->data = $data;
        return $paginator;
    }

    /**
     * 用户信息
     * 2022-7-19
     */
    public function getUserData($id)
    {
        return $this->model::where('id', $id)->first()->makeHidden(['password', 'token', 'created_at', 'updated_at']);
    }
    public function addUser($request)
    {
        return $this->create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'url'=>$request->url,
            'profile'=>$request->profile,
            'avatar'=>asset('images/avatar/avatar.jpg'),
            'status'=>$request->status
        ]);
    }

    /**
     * 获取用户id
     * @param $username
     * @return array
     */
    public function getUserId($username): array
    {
        $user=$this->model::where('username','like','%'.$username.'%')->select('id')->get();
        $data=[];
        foreach ($user as $value){
            $data[]=$value->id;
        }
        return $data;
    }

    /**
     * 搜索用户
     * @param $username
     * @param $email
     * @return mixed
     */
    public function searchUser($username,$email){
        $paginator=$this->model::where('username','like','%'.$username.'%')->where('email','like','%'.$email.'%')->paginate($this->backPageNum());
        $data = $paginator->makeHidden(['password', 'token', 'created_at', 'updated_at'])->map(function ($contact) {
            $contact->create_time = $contact->created_at->format('Y-m-d');
            return $contact;
        });
        $paginator->data = $data;
        return $paginator;
    }
}
