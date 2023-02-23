<?php

namespace App\Traits;

use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;

trait BackToken
{
    /**
     * 获取token
     * 2022-7-5
     * @param array $arr
     * @return bool|string
     */
    public function getBackToken(array $arr = []):bool|string
    {
        return auth('back_auth')->attempt($arr);
    }

    /**
     * 获取token过期时间
     * 2022-7-5
     * @return float|int
     */
    public function getBackTokenExpire(): float|int
    {
        return auth('back_auth')->factory()->getTTL() * 60;
    }

    /**
     * 使token无效
     * 2022-7-5
     * @param $token
     * @return bool
     */
    public function BackTokenInvalidate($token): bool
    {
        try{
            auth('back_auth')->setToken($token)->invalidate();
            return true;
        }catch (TokenExpiredException|TokenInvalidException $e){
            return false;
        }
    }
    /**
     * 通过token获取用户数据
     * 2022-7-5
     * @param $token
     * @return mixed
     */
    public function getDataByBackToken($token){
        return auth('back_auth')->setToken($token)->user();
    }
    /**
     * 刷新token
     * 2022-7-5
     */
    public function refreshBackToken($token)
    {
        try {
            return auth('back_auth')->setToken($token)->refresh();
        } catch (JWTException $e) {
            return false;
        }
    }
    /**
     * 清除认证
     * 2022-7-5
     * @return bool
     */
    public function logoutBackToken(): bool
    {
        try{
            auth('back_auth')->logout();
            return true;
        }catch (JWTException|TokenExpiredException|TokenInvalidException $e){
            return false;
        }

    }

    /**
     * 退出指定token
     * @param $token
     * @return bool
     */
    public function findByBackTokenLogout($token): bool
    {
        try{
            auth('back_auth')->setToken($token)->logout();
            return true;
        }catch (JWTException|TokenExpiredException|TokenInvalidException $e){
            return false;
        }
    }
}
