<?php
namespace App\Services\FrontService;

use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;

class UserService extends BaseService{
    /**
     * 用户注册
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function register($request, UserRepository $repository): JsonResponse
    {
        if ($this->mailVerify("register:email:code:" . $request->email, $request->code)) {
            if ($user = $repository->register($request)) {
                if ($token = $this->getFrontToken($request->only(['username', 'email', 'password']))) {
                    $repository->update($user->id, ['token' => $token]);
                    return $this->Json("用户注册成功", ['token_type' => 'Bearer', 'token' => $token, 'expires' => $this->getFrontTokenExpire()]);
                }
            }
            return $this->Json("用户注册失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json("验证码错误", null, HttpCode::HTTP_PARAMETER_ERROR, false, '验证码验证失败');
    }

    /**
     * 用户登录
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function login($request, UserRepository $repository): JsonResponse
    {
        if ($this->getFrontToken($request->only(['username', 'password']))) {
            $token = $this->getFrontToken($request->only(['username', 'password']));
        } else {
            $token = $this->getFrontToken($request->only(['email' => $request->username, 'password']));
        }

        if ($token) {
            if($this->getDataByFrontToken($token)->status==0){
                $this->FrontTokenInvalidate($token);
                return $this->Json("用户登录失败,当前用户已被禁用", null, HttpCode::HTTP_LOGIN_ERROR, false, '用户被禁用');
            }
            $this->FrontTokenInvalidate($this->getDataByFrontToken($token)->token);
            $repository->update($this->getDataByFrontToken($token)->id, ['token' => $token]);
            return $this->Json("用户登录成功", ['token_type' => 'Bearer', 'token' => $token, 'expires' => $this->getFrontTokenExpire()]);
        }
        return $this->Json("用户登录失败,用户名或密码错误", null, HttpCode::HTTP_LOGIN_ERROR, false, '用户认证失败');
    }

    /**
     * 用户退出
     * 2022-7-19
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function logout(UserRepository $repository): JsonResponse
    {

        if (auth('front_auth')->user()) {
            $repository->update(auth('front_auth')->id(), ['token' => null]);
            return $this->logoutFrontToken() ? $this->Json("用户退出成功") : $this->Json("用户退出失败,服务器错误", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, '服务器错误');
        }
        return $this->Json("token有误或以退出", null, HttpCode::HTTP_PARAMETER_ERROR, false, "token无效");
    }

    /**
     * 找回密码
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function resetPassword($request, UserRepository $repository): JsonResponse
    {
        if ($this->mailVerify("reset:email:code:" . $request->email, $request->code)) {
            if ($repository->exists("email", $request->email)) {
                if (Hash::check($request->password, $repository->findBy("email", $request->email)->password)) {
                    return $this->Json("密码不能与原密码相同", null, HttpCode::HTTP_PARAMETER_ERROR, false, "原密码与现密码相同");
                }
                if ($repository->update($repository->findBy("email", $request->email)->id, ["password" => Hash::make($request->password)])) {
                    $this->FrontTokenInvalidate($repository->findBy("email", $request->email)->token);
                    $repository->update($repository->findBy("email", $request->email)->id, ["token" => null]);
                    return $this->Json("用户密码重置成功");
                }
                return $this->Json("服务器错误", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误,密码重置失败");
            }
        }
        return $this->Json("验证码错误", null, HttpCode::HTTP_PARAMETER_ERROR, false, '验证码验证失败');
    }

    /**
     * 用户修改密码
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updatePassword($request, UserRepository $repository): JsonResponse
    {
        if (Hash::check($request->old_password, auth('front_auth')->user()->getAuthPassword())) {
            if (Hash::check($request->new_password, auth('front_auth')->user()->getAuthPassword())) {
                return $this->Json("密码修改失败，新密码不能与原密码一样", null, HttpCode::HTTP_PARAMETER_ERROR, false, "新密码与原密码一致");
            }
            if ($repository->update(auth('front_auth')->id(), ['password' => Hash::make($request->new_password)])) {
                $this->FrontTokenInvalidate(auth('front_auth')->user()->token);
                $repository->update(auth('front_auth')->id(), ['token'=>null]);
                return $this->Json("密码修改成功");
            }
            return $this->Json("密码修改失败,服务器错误", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
        }
        return $this->Json("密码修改失败，原密码不正确", null, HttpCode::HTTP_PARAMETER_ERROR, false, "原密码不正确");
    }

    /**
     * 获取我的资料
     * 2022-7-19
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getMyData(UserRepository $repository): JsonResponse
    {
        return $this->Json('ok', $repository->getUserData(auth('front_auth')->id())->makeHidden(['status']));
    }

    /**
     * 修改我的资料
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateMyData($request, UserRepository $repository): JsonResponse
    {
        if ($repository->update(auth('front_auth')->id(), $request->only(['name','url','profile']))) {
            return $this->Json('修改成功');
        }
        return $this->Json("修改失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 修改我的头像
     * 2022-7-24
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateMyAvatar($request, UserRepository $repository): JsonResponse
    {
        $filename=auth('front_auth')->user()->username;
        $id=auth('front_auth')->id();
        return $this->avatar($id,$filename,$request,$repository);
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
     * 获取邮箱验证码
     * 2022-7-19
     * @param $request
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getMailCode($request, UserRepository $repository): JsonResponse
    {
        $code = rand(100000, 999999);
        $expireTime = 180;
        if ($request->type == "register") {
            return $this->MailCode($repository->exists("email", $request->email), "register", $request->email, $expireTime, $code);
        }
        if ($request->type == "reset") {
            return $this->MailCode($repository->exists("email", $request->email), "reset", $request->email, $expireTime, $code);
        }
        return $this->Json("你输入的类型有误", null, HttpCode::HTTP_TYPE_ERROR, false, "api的type属性值错误");
    }

    /**
     * 邮箱验证码函数
     * 2022-7-19
     * @param $mailExists
     * @param $type
     * @param $email
     * @param $expireTime
     * @param $code
     * @return JsonResponse
     */
    private function MailCode($mailExists, $type, $email, $expireTime, $code): JsonResponse
    {
        if (Redis::ttl($type . ":email:code:" . $email) > 120) {
            return $this->Json("请求次数频繁",['verifyTime'=>(Redis::ttl($type . ":email:code:" . $email) - 120)], HttpCode::HTTP_REQUEST_NUM_ERROR, false, "验证码获取失败,请在" . (Redis::ttl($type . ":email:code:" . $email) - 120) . "秒后重新获取验证码");
        }
        if ($mailExists && $type == "register") {
            return $this->Json("邮箱以存在", null, HttpCode::HTTP_EMAIL_EXISTS, false, "邮箱地址以存在,无法重复创建");
        }
        if (!$mailExists && $type == "reset") {
            return $this->Json("邮箱不存在", null, HttpCode::HTTP_EMAIL_EXISTS, false, "邮箱不存在，无法发送验证码");
        }
        Redis::setex($type . ":email:code:" . $email, $expireTime, $code);
        $this->getMail("中国小丑邮箱验证", 'email.email_code', $email, ["email" => $email, "code" => $code]);
        return $this->Json("邮箱验证码发送成功");
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

    /**
     * 获取用户资料
     * @param $request
     * @param UserRepository $userRepository
     * @param AdminRepository $adminRepository
     * @return JsonResponse
     */
    public function getUserData($request,UserRepository $userRepository,AdminRepository $adminRepository): JsonResponse
    {
        if($request->type=='front'){
            if($userRepository->exists('username',$request->username)) {
                $id=$userRepository->findBy('username',$request->username)->id;
                return $this->Json('ok', $userRepository->getUserData($id));
            }
            return $this->Json("用户不存在", null, HttpCode::HTTP_TYPE_ERROR, false, "用户不存在");
        }
        if($request->type=="back"){
            if($adminRepository->exists('username',$request->username)){
                $id=$adminRepository->findBy('username',$request->username)->id;
                return $this->Json('ok',$adminRepository->getUserData($id));
            }
            return $this->Json("用户不存在", null, HttpCode::HTTP_TYPE_ERROR, false, "用户不存在");
        }
        return $this->Json("用户类型错误", null, HttpCode::HTTP_TYPE_ERROR, false, "用户类型错误");
    }
}

