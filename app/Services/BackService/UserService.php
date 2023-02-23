<?php
namespace App\Services\BackService;

use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserService extends BaseService{

    /**
     * 获取用户列表
     * 2022-9-1
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getUserList(UserRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->getUserList());
    }

    /**
     * 获取用户资料
     * 2022-9-1
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getUserData($request,UserRepository $repository): JsonResponse
    {
        if($repository->exists('id',$request->id)){
            return $this->Json('ok',$repository->getUserData($request->id));
        }
        return $this->Json('获取失败', null, HttpCode::HTTP_TYPE_ERROR, false, '用户不存在');
    }

    /**
     * 添加用户
     * 2022-9-2
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function addUser($request,UserRepository $repository): JsonResponse
    {
        if($user=$repository->addUser($request)){
            return $this->Json('用户:' . $user->username . '添加成功');
        }
        return $this->Json("用户添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改用户信息
     * 2022-9-2
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateUser($request,UserRepository $repository): JsonResponse
    {
        if ($user = $repository->findBy('username', $request->username)) {
            if ($user->id != $request->id) {
                return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, '用户名称以存在');
            }
        }
        if ($user = $repository->findBy('email', $request->email)) {
            if ($user->id != $request->id) {
                return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, '邮箱以存在');
            }
        }
        $token = $repository->findById($request->id)->token;
        $username=$repository->findById($request->id)->username;
        if ($token != null) {
            $this->BackTokenInvalidate($token);
        }
        if($repository->update($request->id,[
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'url'=>$request->url,
            'profile'=>$request->profile,
            'token'=>null,
            'avatar'=>asset('images/avatar/avatar.jpg'),
            'status'=>$request->status
        ])){
            Storage::disk('images')->delete('avatar/front/'.$username.'.jpg');
            return $this->Json('用户修改成功');
        }
        return $this->Json("用户修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改用户头像
     * 2022-9-3
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateUserAvatar($request,UserRepository $repository): JsonResponse
    {
        if($request->id==null){
            return $this->Json('请输入id',null,HttpCode::HTTP_TYPE_ERROR,false,'id不能为空');
        }
        $filename=$repository->findById($request->id)->username;
        return $this->avatar($request->id,$filename,$request,$repository);
    }

    /**
     * 头像上传函数
     * 2022-7-24
     * @param $id
     * @param $filename
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function avatar($id, $filename, $request, UserRepository $repository): JsonResponse
    {
        $img=Image::make(file_get_contents($request->file('avatar')->getRealPath()))->resize(640,640);
        $img->save('images/avatar/front/'.$filename.'.jpg');
        if($repository->update($id,['avatar'=>asset('images/avatar/front/'.$filename.'.jpg')])){
            return $this->Json('头像上传成功',['avatar'=>asset('images/avatar/front/'.$filename.'.jpg')]);
        }
        return $this->Json("上传失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 删除用户
     * 2022-9-3
     * @param $request
     * @param UserRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteUser($request,UserRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        foreach($request->ids as $value){
            if ($value == null) {
                return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, 'ids数组元素不能为null');
            }
            if($user=$repository->findById($value)){
                $token =$user->token;
                if ($token != null) {
                    $this->BackTokenInvalidate($token);
                }
                Storage::disk('images')->delete('avatar/front/'.$user->username.'.jpg');
                $commentRepository->UserDetachComment($value);
                $repository->delete($value);
            }
        }
        return $this->Json("用户删除成功");
    }

    /**
     * 用户搜索
     * @param $request
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function searchUser($request,UserRepository $userRepository): JsonResponse
    {
        return $this->Json('ok',$userRepository->searchUser($request->username,$request->email));
    }
}
