<?php

namespace App\Http\Middleware\Project;

use App\Traits\HttpCode;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * 此中间件用于校验验证码是否有效，验证码存储在redis中
 */
class VerifyCode extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        if(!$request->code){
            return $this->Json("验证码不能为空",null,HttpCode::HTTP_PARAMETER_ERROR,false,"验证码参数为空");
        }
        if($this->verify($request->code)){
            return $next($request);
        }
        return $this->Json("验证码错误",null,HttpCode::HTTP_PARAMETER_ERROR,false,"验证码无效");
    }
}
