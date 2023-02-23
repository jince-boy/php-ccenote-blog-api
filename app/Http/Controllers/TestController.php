<?php

namespace App\Http\Controllers;
use App\Models\Comments;
use App\Repositories\AdminRepository;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Services\BackService\TagService;
use App\Services\FrontService\ArticleService;
use App\Services\FrontService\CommentService;
use App\Services\FrontService\CountService;
use App\Services\FrontService\MasterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{

    /**
     * 此类为测试类
     * @param Request $request
     * @return Request
     */
    public function index(Request $request)
    {
       return $request;
    }


}
