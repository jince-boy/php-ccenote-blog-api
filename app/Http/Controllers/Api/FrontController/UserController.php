<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ImagesRequest;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Services\FrontService\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * 用户注册
     * 2022-8-31
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function register(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->register($request, $repository);
    }

    /**
     * 用户登录
     * 2022-7-5
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function login(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->login($request, $repository);
    }

    /**
     * 退出登录
     * 2022-7-5
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function logout(UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->logout($repository);
    }

    /**
     * 找回密码
     * 2022-7-10
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function resetPassword(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->resetPassword($request, $repository);
    }

    /**
     * 修改密码
     * 2022-7-10
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updatePassword(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->updatePassword($request, $repository);
    }

    /**
     * 获取我的信息
     * 2022-7-19
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getMyData(UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->getMyData($repository);
    }

    /**
     * 修改我的资料
     * 2022-7-21
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateMyData(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->updateMyData($request, $repository);
    }

    /**
     * 修改我的头像
     * 2022-7-21
     * @param ImagesRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateAvatar(ImagesRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->updateMyAvatar($request,$repository);
    }
    /**
     * 获取邮箱验证码
     * 2022-8-31
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getMailCode(UserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->getMailCode($request, $repository);
    }

    /**
     * 获取验证码
     * 2022-8-31
     * @param UserService $userService
     * @return JsonResponse
     */
    public function getVerifyCode(UserService $userService): JsonResponse
    {
        return $userService->getImageVerifyCode();
    }

    /**
     * 获取用户资料
     * @param UserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @param AdminRepository $adminRepository
     * @return JsonResponse
     */
    public function getUserData(UserRequest $request,UserService $userService,UserRepository $repository,AdminRepository $adminRepository): JsonResponse
    {
        return $userService->getUserData($request, $repository,$adminRepository);
    }
}
