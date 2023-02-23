<?php

namespace App\Traits;

use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Redis;

trait VerifyCode
{
    private $verifyExpire=60*3;

    /**
     * 获取验证码
     * 2022-7-5
     * @return string
     */
    public function getVerifyCode(): string
    {
        //使用PhraseBuilder控制验证码位数
        $captcha=new CaptchaBuilder(null,new PhraseBuilder(4));
        $captcha->build();
        $code=strtolower($captcha->getPhrase());
        $base64=$captcha->inline();
        Redis::setex($code,$this->verifyExpire,$code);
        return $base64;
    }

    /**
     * 验证验证码
     * 2022-7-5
     * @param $code
     * @return bool
     */
    public function verify($code): bool
    {
        if(strtolower($code)==Redis::get(strtolower($code))){
            $this->delVerifyCode($code);
            return true;
        }
        return false;
    }

    /**
     * 获取验证码过期时间
     * 2022-7-5
     * @return float|int
     */
    public function getVerifyCodeExpire(): float|int
    {
        return $this->verifyExpire;
    }

    /**
     * 删除验证码
     * 2022-7-5
     * @param $key
     * @return bool
     */
    public function delVerifyCode($key): bool
    {
        if(Redis::del($key)){
            return true;
        }
        return false;
    }

    /**
     * 获取验证码验证剩余时间
     * 2022-7-5
     * @param $key
     * @return mixed
     */
    public static function getVerifyTime($key): mixed
    {
        return Redis::ttl($key);
    }
}
