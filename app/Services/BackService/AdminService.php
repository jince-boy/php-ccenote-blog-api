<?php

namespace App\Services\BackService;

use App\Repositories\AdminRepository;
use App\Repositories\CommentRepository;
use App\Repositories\RoleRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class AdminService extends BaseService
{

    /**
     * 用户登录
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function login($request, AdminRepository $repository): JsonResponse
    {
        if ($this->getBackToken($request->only(['username', 'password']))) {
            $token = $this->getBackToken($request->only(['username', 'password']));
        } else {
            $token = $this->getBackToken($request->only(['email' => $request->username, 'password']));
        }
        if ($token) {
            if($this->getDataByBackToken($token)->status==0){
                $this->FrontTokenInvalidate($token);
                return $this->Json("用户登录失败,当前用户已被禁用", null, HttpCode::HTTP_LOGIN_ERROR, false, '用户被禁用');
            }
            $this->BackTokenInvalidate($this->getDataByBackToken($token)->token);
            $repository->update($this->getDataByBackToken($token)->id, ['token' => $token]);
            return $this->Json("用户登录成功", ['token_type' => 'Bearer', 'token' => $token, 'expires' => $this->getBackTokenExpire()]);
        }
        return $this->Json("用户登录失败,用户名或密码错误", null, HttpCode::HTTP_LOGIN_ERROR, false, '用户认证失败');
    }

    /**
     * 用户退出
     * 2022-7-19
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function logout(AdminRepository $repository): JsonResponse
    {

        if (auth('back_auth')->user()) {
            $repository->update(auth('back_auth')->id(), ['token' => null]);
            return $this->logoutBackToken() ? $this->Json("用户退出成功") : $this->Json("用户退出失败,服务器错误", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, '服务器错误');
        }
        var_dump(auth('back_auth')->user());
        return $this->Json("token有误或以退出", null, HttpCode::HTTP_PARAMETER_ERROR, false, "token无效");
    }

    /**
     * 用户修改密码
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updatePassword($request, AdminRepository $repository): JsonResponse
    {
        if (Hash::check($request->old_password, auth('back_auth')->user()->getAuthPassword())) {
            if (Hash::check($request->new_password, auth('back_auth')->user()->getAuthPassword())) {
                return $this->Json("密码修改失败，新密码不能与原密码一样", null, HttpCode::HTTP_PARAMETER_ERROR, false, "新密码与原密码一致");
            }
            if ($repository->update(auth('back_auth')->id(), ['password' => Hash::make($request->new_password)])) {
                $this->BackTokenInvalidate(auth('back_auth')->user()->token);
                $repository->update(auth('back_auth')->id(), ['token'=>null]);
                return $this->Json("密码修改成功");
            }
            return $this->Json("密码修改失败,服务器错误", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json("密码修改失败，原密码不正确", null, HttpCode::HTTP_PARAMETER_ERROR, false, "原密码不正确");
    }

    /**
     * 获取我的资料
     * 2022-7-19
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */
    public function getMyData(AdminRepository $repository,RoleRepository $roleRepository): JsonResponse
    {
        $data=$repository->getUserData(auth('back_auth')->id())->makeHidden(['status'])->toArray();
        $data['menu']=$roleRepository->getMenu(auth('back_auth')->user()->role_id);
        return $this->Json('ok',$data);
    }

    /**
     * 修改我的资料
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateMyData($request, AdminRepository $repository): JsonResponse
    {
        if ($repository->update(auth('back_auth')->id(),$request->only(['name','url','profile']))) {
            return $this->Json('修改成功');
        }
        return $this->Json("修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改我的头像
     * 2022-7-24
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateMyAvatar($request, AdminRepository $repository): JsonResponse
    {

        $filename=auth('back_auth')->user()->username;
        $id=auth('back_auth')->id();
        return $this->avatar($id,$filename,$request,$repository);
    }

    /**
     * 头像上传函数
     * 2022-7-24
     * @param $filename
     * @param $id
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function avatar($id, $filename, $request, AdminRepository $repository): JsonResponse
    {
        $img=Image::make(file_get_contents($request->file('avatar')->getRealPath()))->resize(640,640);
        $img->save('images/avatar/back/'.$filename.'.jpg');
        if($repository->update($id,['avatar'=>asset('images/avatar/back/'.$filename.'.jpg')])){
            return $this->Json('头像上传成功',['avatar'=>asset('images/avatar/back/'.$filename.'.jpg')]);
        }
        return $this->Json("上传失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }


    /**
     * 获取管理员列表
     * 2022-7-19
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getAdminList(AdminRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->getAdminList());
    }

    /**
     * 获取管理员信息
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getAdminData($request, AdminRepository $repository): JsonResponse
    {
        if ($repository->exists('id', $request->id)) {
            return $this->Json('ok', $repository->getUserData($request->id));
        }
        return $this->Json('获取失败', null, HttpCode::HTTP_TYPE_ERROR, false, '用户不存在');
    }
    /**
     * 添加管理员用户
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */
    public function addAdmin($request, AdminRepository $repository, RoleRepository $roleRepository): JsonResponse
    {
        if ($roleRepository->exists('id', $request->role_id)) {
            if ($user = $repository->add($request)) {
                return $this->Json('用户:' . $user->username . '添加成功');
            }
            return $this->Json("用户添加失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, '角色不存在');
    }

    /**
     * 修改管理员用户
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */
    public function updateAdmin($request, AdminRepository $repository, RoleRepository $roleRepository): JsonResponse
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
        if (!$roleRepository->exists('id', $request->role_id)) {
            return $this->Json('字段错误', null, HttpCode::HTTP_TYPE_ERROR, false, '角色不存在');
        }
        $token = $repository->findById($request->id)->token;
        $username=$repository->findById($request->id)->username;
        if ($token != null) {
            $this->BackTokenInvalidate($token);
        }

        if ($repository->update($request->id, [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'email' => $request->email,
            'url'=>$request->url,
            'profile'=>$request->profile,
            'token' => null,
            'status' => $request->status,
            'role_id' => $request->role_id
        ])) {
            Storage::disk('images')->delete('avatar/back/'.$username.'.jpg');
            return $this->Json('用户修改成功');
        }
        return $this->Json("用户修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改管理员头像
     * 2022-7-24
     * @param $request
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateAdminAvatar($request, AdminRepository $repository): JsonResponse
    {
        if($request->id==null){
            return $this->Json('请输入id',null,HttpCode::HTTP_TYPE_ERROR,false,'id不能为空');
        }
        $filename=$repository->findById($request->id)->username;
        return $this->avatar($request->id,$filename,$request,$repository);
    }

    /**
     * 删除管理员
     * 2022-7-19
     * @param $request
     * @param AdminRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteAdmin($request, AdminRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        if(in_array(1,$request->ids)){
            return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, '系统用户不允许删除');
        }
        foreach($request->ids as $value){
            if ($value == null) {
                return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, 'ids数组元素不能为null');
            }
            if($user=$repository->findById($value)){
                $token =$user->token;
                if ($token != null) {
//                    $token = $this->refreshBackToken($token);
//                    $this->findByBackTokenLogout($token);
                    $this->BackTokenInvalidate($token);
                }
                Storage::disk('images')->delete('avatar/back/'.$user->username.'.jpg');
                $commentRepository->AdminDetachComment($value);
                $repository->delete($value);
            }
        }
        return $this->Json("用户删除成功");
    }


    /**
     * 图片验证码
     * 2022-7-19
     * @return JsonResponse
     */
    public function getImageVerifyCode(): JsonResponse
    {
        return $this->Json('验证码获取成功', ['base64' => $this->getVerifyCode(), 'expire' => $this->getVerifyCodeExpire()]);
    }
}
