<?php

namespace App\Http\Middleware\Project;

use App\Repositories\ConfigRepository;
use App\Repositories\AdminRepository;
use App\Traits\HttpCode;
use Closure;
use Illuminate\Http\Request;

/**
 * 此中间件用于拦截用户注册时，系统是否拒绝了用户的注册请求
 */
class IsRegister extends BaseMiddleware
{

    public $repository;


    public function __construct(ConfigRepository $repository)
    {
        $this->repository=$repository;
    }

    public function handle(Request $request, Closure $next)
    {
        if($this->repository->findBy("is_register",true)){
            return $next($request);
        }
        return $this->Json("注册功能以关闭",null,HttpCode::HTTP_BAN_REGISTER,false,"注册功能以被停用，请联系网站管理员");
    }
}
