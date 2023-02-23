<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\ImagesRequest;
use App\Repositories\AdminRepository;
use App\Repositories\CommentRepository;
use App\Repositories\RoleRepository;
use App\Services\BackService\AdminService;
use Illuminate\Http\JsonResponse;

class AdminController extends Controller
{
    /**
     * 用户登录
     * 2022-7-5
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function login(AdminRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->login($request, $repository);
    }

    /**
     * 获取登录验证码
     * 2022-7-5
     * @param AdminService $adminService
     * @return JsonResponse
     */
    public function getVerifyCode(AdminService $adminService): JsonResponse
    {
        return $adminService->getImageVerifyCode();
    }

    /**
     * 退出登录
     * 2022-7-5
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function logout(AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->logout($repository);
    }

    /**
     * 修改密码
     * 2022-7-10
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updatePassword(AdminRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->updatePassword($request, $repository);
    }

    /**
     * 获取我的信息
     * 2022-7-19
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */
    public function getMyData(AdminService $adminService, AdminRepository $repository,RoleRepository $roleRepository): JsonResponse
    {
        return $adminService->getMyData($repository,$roleRepository);
    }

    /**
     * 修改我的资料
     * 2022-7-21
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateMyData(AdminRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->updateMyData($request, $repository);
    }

    /**
     * 修改我的头像
     * 2022-7-21
     * @param ImagesRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateAvatar(ImagesRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->updateMyAvatar($request,$repository);
    }


    /**
     * 获取管理员列表
     * 2022-7-18
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getAdminList(AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->getAdminList($repository);
    }

    /**
     * 获取管理员信息
     * 2022-7-19
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function getAdmin(AdminRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->getAdminData($request, $repository);
    }

    /**
     * 添加用户
     * 2022-7-15
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */
    public function addAdmin(AdminRequest $request, AdminService $adminService, AdminRepository $repository, RoleRepository $roleRepository): JsonResponse
    {
        return $adminService->addAdmin($request, $repository, $roleRepository);
    }

    /**
     * 修改管理员资料
     * 2022-7-16
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @param RoleRepository $roleRepository
     * @return JsonResponse
     */

    public function updateAdminUser(AdminRequest $request, AdminService $adminService, AdminRepository $repository, RoleRepository $roleRepository): JsonResponse
    {
        return $adminService->updateAdmin($request, $repository, $roleRepository);
    }

    /**
     * 修改管理员头像
     * 2022-7-24
     * @param ImagesRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @return JsonResponse
     */
    public function updateAdminUserAvatar(ImagesRequest $request, AdminService $adminService, AdminRepository $repository): JsonResponse
    {
        return $adminService->updateAdminAvatar($request,$repository);
    }

    /**
     * 删除用户
     * 2022-7-16
     * @param AdminRequest $request
     * @param AdminService $adminService
     * @param AdminRepository $repository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function deleteAdminUser(AdminRequest $request, AdminService $adminService, AdminRepository $repository,CommentRepository $commentRepository): JsonResponse
    {
        return $adminService->deleteAdmin($request, $repository,$commentRepository);
    }

}
