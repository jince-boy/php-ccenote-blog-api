<?php

namespace App\Traits;

use App\Mail\VerifyCode;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

trait Email
{
    /**
     * 发送邮件
     * 2022-7-5
     * @param $title
     * @param $views
     * @param $address
     * @param array $data
     * @return void
     */
    public function getMail($title,$views,$address,array $data): void
    {
        Mail::send(new VerifyCode($title,$views,$address,$data));
    }

    /**
     * 邮箱验证码验证
     * 2022-7-5
     * @param $key
     * @param $code
     * @return bool
     */
    public function mailVerify($key,$code): bool
    {
        return Redis::get($key)==$code;
    }

    /**
     * 从待验证中删除验证码
     * 2022-7-5
     * @param $key
     * @return mixed
     */
    public function mailDel($key){
        return Redis::del($key);
    }
}
