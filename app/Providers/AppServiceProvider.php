<?php

namespace App\Providers;

use App\Services\Project\LengthAwarePaginatorService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Validator;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //不使用Sanctum的默认迁移文件personal_access_tokens
        //--------------------------------------------------------
        Sanctum::ignoreMigrations();
        //--------------------------------------------------------
        $this->app->bind(LengthAwarePaginator::class,function ($app,$options){
            return new LengthAwarePaginatorService($options['items'], $options['total'], $options['perPage'], $options['currentPage'] , $options['options']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //解决数据库迁移报错信息
        Schema::defaultStringLength(191);

        /**
         * 自定义表单验证规则用户验证手机号
         */
        \Validator::extend('mobile',function($attribute,$value,$parameters,Validator $validator){
            return $validator->validateRegex($attribute,$value,['/^(81)?\-?0?[789](?:\d{8}|\d{9})$/']);
        });

        /**
         * 自定义表单验证规则验证图片大小
         */
        \Validator::extend('image_min',function ($attribute,$value,$parameters,Validator $validator){
            $validator->addReplacer('image_min',function($message,$attribute,$rule,$parameters){
                return str_replace([':image_min'],$parameters,$message);
            });

            if(gettype($value)!="object"){
                return false;
            }
            return $parameters[0]*1024<=$value->getSize();
        });

        \Validator::extend('image_max',function ($attribute,$value,$parameters,Validator $validator){
            $validator->addReplacer('image_max',function($message,$attribute,$rule,$parameters){
                return str_replace([':image_max'],$parameters,$message);
            });
            if(gettype($value)!="object"){
                return false;
            }
            return $parameters[0]*1024>=$value->getSize();
        });

        /**
         * 自定义表单验证规则，用于验证视频大小
         */
        \Validator::extend('video_min',function ($attribute,$value,$parameters,Validator $validator){
            $validator->addReplacer('video_min',function($message,$attribute,$rule,$parameters){
                return str_replace([':video_min'],$parameters,$message);
            });
            if(gettype($value)!="object"){
                return false;
            }
            return $parameters[0]*1024<=$value->getSize();
        });
        \Validator::extend('video_max',function ($attribute,$value,$parameters,Validator $validator){
            $validator->addReplacer('video_max',function($message,$attribute,$rule,$parameters){
                return str_replace([':video_max'],$parameters,$message);
            });
            if(gettype($value)!="object"){
                return false;
            }
            return $parameters[0]*1024>=$value->getSize();
        });
    }
}
