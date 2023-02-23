<?php

namespace App\Traits;

class HttpCode
{
    public const HTTP_TYPE_ERROR=10003;//参数有误
    public const HTTP_PARAMETER_ERROR=10004;//参数无效
    // 200表示服务器成功地接受了客户端请求
    public const HTTP_OK = 200;//请求成功。一般用于GET与POST请求
    public const HTTP_CREATED = 201;//已创建。成功请求并创建了新的资源
    public const HTTP_NO_CONTENT = 204;//服务器成功处理，但未返回内容
    public const HTTP_RESET_CONTENT = 205;//重置内容。服务器处理成功
    public const HTTP_EMAIL_EXISTS=20005;//内容以存在或不存在
    public const HTTP_BAN_REGISTER=20006;//注册功能以关闭
    public const HTTP_REQUEST_NUM_ERROR=20007;//请求次数频繁，导致失败
    public const HTTP_LOGIN_ERROR=20008;//认证失败
    public const HTTP_PERMISSION_ERROR=401;//权限认证失败
    public const HTTP_PARAMETER_EQUAL=20009;//参数相同


    // 300开头的表示服务器重定向
    public const HTTP_MOVED_PERMANENTLY = 301;//永久移动。请求的资源已被永久的移动到新URI
    public const HTTP_FOUND = 302;//临时移动。与301类似。但资源只是临时被移动。客户端应继续使用原有URI
    public const HTTP_NOT_MODIFIED = 304;//未修改。所请求的资源未修改

    // 400开头的表示客户端错误请求错误，请求不到数据，或者找不到等等
    public const HTTP_BAD_REQUEST = 400;//客户端请求的语法错误，服务器无法理解
    public const HTTP_UNAUTHORIZED = 401;//请求要求用户的身份认证
    public const HTTP_FORBIDDEN = 403;//服务器理解请求客户端的请求，但是拒绝执行此请求
    public const HTTP_NOT_FOUND = 404;//服务器无法根据客户端的请求找到资源
    public const HTTP_REQUEST_TIME_OUT = 408;//服务器等待客户端发送的请求时间过长，超时


    // 500开头的表示服务器错误
    public const HTTP_INTERNAL_SERVER_ERROR = 500;//服务器内部错误，无法完成请求
}
