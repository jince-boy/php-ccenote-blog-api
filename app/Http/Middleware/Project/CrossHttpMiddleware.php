<?php

namespace App\Http\Middleware\Project;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CrossHttpMiddleware
{
    /**
     * 此中间件用于指定域名来跨域
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : '';
        $allow_origin = explode("||", env("CROSS_URL"));
        if (in_array($origin, $allow_origin)) {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN');
            header('Access-Control-Expose-Headers: *');
            header('Access-Control-Allow-Methods: *');
            header('Access-Control-Allow-Credentials: true');
        }
        return $response;
    }
}
