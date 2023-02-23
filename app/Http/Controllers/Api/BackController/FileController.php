<?php

namespace App\Http\Controllers\Api\BackController;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Services\BackService\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * 获取文件列表
     * @param FileRequest $request
     * @param FileService $service
     * @return JsonResponse
     */
    public function getFileList(FileRequest $request,FileService $service): JsonResponse
    {
        return $service->getFileList($request);
    }

    /**
     * 上传文件
     * @param FileRequest $request
     * @param FileService $service
     * @return JsonResponse
     */
    public function uploadFile(FileRequest $request,FileService $service): JsonResponse
    {
        return $service->uploadFile($request);
    }

    /**
     * 删除文件
     * @param FileRequest $request
     * @param FileService $service
     * @return JsonResponse
     */
    public function deleteFile(FileRequest $request,FileService $service): JsonResponse
    {
        return $service->deleteFile($request);
    }
}
