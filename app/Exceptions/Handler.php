<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $e)
    {
        if($e instanceof NotFoundHttpException){
               return response()->view('404');
        }
        if($e instanceof TokenExpiredException){
            return $this->ApiException("令牌以过期");
        }
        if($e instanceof MethodNotAllowedHttpException){
            return $this->ApiException("请求方式错误");
        }
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
    //自定义方法
    public function ApiException($message): JsonResponse
    {
        return response()->json([
            'message'=>$message
        ]);
    }
}
