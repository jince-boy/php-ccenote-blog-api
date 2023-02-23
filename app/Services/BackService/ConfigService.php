<?php
namespace App\Services\BackService;

use App\Repositories\ConfigRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use App\Utils\Keyword;
use Illuminate\Http\JsonResponse;
use Intervention\Image\Facades\Image;


class ConfigService extends BaseService{

    private $keyword;
    /**
     * 获取网站配置信息
     * 2022-8-26
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function getConfig(ConfigRepository $repository): JsonResponse
    {
        return $this->Json('ok',$repository->findById(1)->first());
    }

    /**
     * 修改网站配置信息
     * 2022-8-26
     * @param $request
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function setConfig($request,ConfigRepository $repository): JsonResponse
    {
        if($repository->update(1,$request->except(['logo']))){
            return $this->Json('网站配置修改成功');
        }
        return $this->Json('网站配置修改失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }

    /**
     * 上传网站Logo
     * @param $request
     * @param ConfigRepository $repository
     * @return JsonResponse
     */
    public function setLogo($request,ConfigRepository $repository): JsonResponse
    {
        $img=Image::make(file_get_contents($request->file('logo')->getRealPath()));
        $img->save('images/logo/logo.png');
        if($repository->update(1,['logo'=>asset('images/logo/logo.png')])){
            return $this->Json('logo上传成功',['logo'=>asset('images/logo/logo.png')]);
        }
        return $this->Json("上传失败", null, HttpCode::HTTP_INTERNAL_SERVER_ERROR, false, "服务器错误");
    }

    /**
     * 获取评论关键字
     * @return JsonResponse
     */
    public function getKeywords(): JsonResponse
    {
        $this->keyword=new Keyword();
        return $this->Json('ok',$this->keyword->getKeywords());
    }

    /**
     * 设置评论关键字
     * @param $request
     * @return JsonResponse
     */
    public function setKeyword($request): JsonResponse
    {
        $this->keyword=new Keyword();
        if($this->keyword->setKeywords($request->keyword)){
            return $this->Json('评论关键字保存成功');
        }
        return $this->Json("评论关键字保存失败",null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }
}
