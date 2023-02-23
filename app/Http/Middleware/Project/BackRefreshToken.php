<?php

namespace App\Http\Middleware\Project;

use App\Models\Admins;
use App\Traits\HttpCode;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

/**
 * 此中间件用于认证，刷新后台用户token的中间件，主要依赖于redis来缓存15秒的token以解决token刷新后立马不能使用的并发请求问题
 */
class BackRefreshToken extends BaseMiddleware
{
    public $token;
    public $key;

    public function handle(Request $request, Closure $next)
    {
        $this->key = 'Back:' . $request->header('authorization');
        try {
            $this->authenticate($request);
        } catch (UnauthorizedHttpException $e) {
            try {
                if ($value = Redis::get($this->key)) {
                    $request->headers->set('Authorization', 'Bearer ' . $value);
                    return $next($request);
                } else {
                    $this->token = $this->auth->parseToken()->refresh();
                    Redis::setex($this->key, 15, $this->token);
                }
            } catch (JWTException $e) {
                return response()->json(['code' => HttpCode::HTTP_PERMISSION_ERROR, 'status' => false, 'message' => "用户未登录", 'error' => 'token失效或无效']);
            }
            if ($this->auth->setToken($this->token)->getClaim('role') == 'admin') {
                Admins::find(auth('back_auth')->setToken($this->token)->user()->id)->update(['token' => $this->token]);
                if ($request->path() != 'api/back/user/logout') {
                    $request->headers->set('Authorization', 'Bearer ' . $this->token);
                    $response = $next($request);
                    $response->header('Access-Control-Expose-Headers', 'Authorization');
                    return $this->setAuthenticationHeader($response, $this->token);
                }
            }
            return response()->json(['code' => HttpCode::HTTP_PERMISSION_ERROR, 'status' => false, 'message' => "没有此用户", 'error' => '没有此用户']);
        }
        return $next($request);
    }

    public function authenticate(Request $request)
    {
        $this->checkForToken($request);
        try {
            if (!auth('back_auth')->user()) {
                throw new UnauthorizedHttpException('jwt-auth', 'User not found');
            }
        } catch (JWTException $e) {
            throw new UnauthorizedHttpException('jwt-auth', $e->getMessage(), $e, $e->getCode());
        }
    }
}
