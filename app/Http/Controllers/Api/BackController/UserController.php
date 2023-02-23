<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Http\Requests\ImagesRequest;
use App\Http\Requests\BackUserRequest;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\BackService\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 搜索用户
     * @param BackUserRequest $request
     * @param UserService $service
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function searchUser(BackUserRequest $request,UserService $service,UserRepository $userRepository): JsonResponse
    {
        return $service->searchUser($request,$userRepository);
    }
    /**
     * 获取用户列表
     * 2022-9-1
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getUserList(UserService $userService,UserRepository $repository): JsonResponse
    {
        return $userService->getUserList($repository);
    }

    /**
     * 获取用户资料
     * 2022-9-2
     * @param BackUserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function getUser(BackUserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->getUserData($request,$repository);
    }

    /**
     * 添加用户
     * 2022-9-2
     * @param BackUserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function addUser(BackUserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->addUser($request,$repository);
    }

    /**
     * 修改用户信息
     * 2022-9-2
     * @param BackUserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateUser(BackUserRequest $request, UserService $userService, UserRepository $repository): JsonResponse
    {
        return $userService->updateUser($request,$repository);
    }

    /**
     * 修改用户头像
     * 2022-9-3
     * @param ImagesRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function updateUserAvatar(ImagesRequest $request,UserService $userService,UserRepository $repository): JsonResponse
    {
        return $userService->updateUserAvatar($request,$repository);
    }

    /**
     * 删除用户
     * 2022-9-3
     * @param BackUserRequest $request
     * @param UserService $userService
     * @param UserRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteUser(BackUserRequest $request, UserService $userService, UserRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        return $userService->deleteUser($request,$repository,$commentRepository);
    }
}
