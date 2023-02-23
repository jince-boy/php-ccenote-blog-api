<?php

namespace App\Http\Middleware\Project;

use App\Traits\ApiJson;
use App\Traits\Email;
use App\Traits\VerifyCode;
use Illuminate\Http\Request;

/**
 * 自定义中间件基类
 */
class BaseMiddleware
{
    use ApiJson,Email,VerifyCode;
}
