<?php

namespace App\Services\BackService;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TagRepository;
use App\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;

class HomeService extends BaseService
{

    /**
     * 获取网站数据
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @param CategoryRepository $categoryRepository
     * @param TagRepository $tagRepository
     * @param CommentRepository $commentRepository
     * @return JsonResponse
     */
    public function getWebData(UserRepository $userRepository, ArticleRepository $articleRepository, CategoryRepository $categoryRepository, TagRepository $tagRepository, CommentRepository $commentRepository): JsonResponse
    {
        $data = [];
        $data['user'] = [
            'num' => count($userRepository->all())
        ];
        $data['article'] = [
            'num' => count($articleRepository->all()),
            'views' => $articleRepository->all()->sum('page_views')
        ];
        $data['category'] = [
            'num' => count($categoryRepository->all())
        ];
        $data['tag'] = [
            'num' => count($tagRepository->all())
        ];
        $data['comment'] = [
            'num' => count($commentRepository->all())
        ];
        $loaded_extensions = get_loaded_extensions();
        $extensions = '';
        foreach ($loaded_extensions as $value) {
            $extensions .= $value . ', ';
        }
        $data['server'] = [
            [
                'name'=>'程序版本',
                'key'=>'app_version',
                'value'=>'1.0.0'
            ],
            [
                'name'=>'Laravel版本',
                'key'=>'laravel_version',
                'value'=>app()::VERSION
            ],
            [
                'name'=>'PHP版本',
                'key'=>'php_version',
                'value'=>PHP_VERSION
            ],
            [
                'name'=>'服务器系统',
                'key'=>'os',
                'value'=>PHP_OS
            ],
            [
                'name'=>'服务器域名',
                'key'=>'server_name',
                'value'=>$_SERVER['SERVER_NAME']
            ],
            [
                'name'=>'服务器地址',
                'key'=>'server_addr',
                'value'=>$_SERVER['SERVER_ADDR']
            ],
            [
                'name'=>'服务器端口',
                'key'=>'server_port',
                'value'=>$_SERVER['SERVER_PORT']
            ],
            [
                'name'=>'服务器软件',
                'key'=>'server_software',
                'value'=>$_SERVER['SERVER_SOFTWARE']
            ],
            [
                'name'=>'以加载模块',
                'key'=>'extensions',
                'value'=>$extensions
            ]
        ];
        return $this->Json('ok',$data);
    }

}
