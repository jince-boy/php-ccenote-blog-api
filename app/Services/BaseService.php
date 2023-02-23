<?php

namespace App\Services;

use App\Traits\ApiJson;
use App\Traits\Email;
use App\Traits\FrontToken;
use App\Traits\BackToken;
use App\Traits\VerifyCode;

/**
 * 定义service类的基类，引用多个特性
 */
class BaseService
{
    use ApiJson,BackToken,FrontToken,Email,VerifyCode;
}
