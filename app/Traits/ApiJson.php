<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiJson
{
    /**
     * 返回Json数据工具类
     */
    public function Json($message = "",$data = null,$code = HttpCode::HTTP_OK, $status = true,$error = null): JsonResponse
    {
        $res = [
            "code" => $code,
            "status" => $status,
            "message" => $message,
        ];
        if ($data) {
            $res['data'] = $data;
        }
        if ($error) {
            $res['error'] = $error;
        }
        return response()->json($res);
    }
}
