<?php
namespace App\Services\BackService;
use App\Repositories\BannerRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class BannerService extends BaseService{
    /**
     * 获取Banner列表
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function getBannerList(BannerRepository $repository): JsonResponse
    {
        $list=$repository->all()->map(function ($context){
            $context->path=asset($context->path);
            return $context;
        });
        return $this->Json('ok',$list);
    }

    /**
     * 获取Banner信息
     * @param $request
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function getBanner($request,BannerRepository $repository): JsonResponse
    {
        if(!$repository->exists('id',$request->id)){
            return $this->Json('获取失败',null,HttpCode::HTTP_TYPE_ERROR,false,'banner Id不存在');
        }
        $banner=$repository->findById($request->id);
        $banner->path=asset($banner->path);
        return $this->Json('ok',$banner);
    }
    /**
     * 添加Banner
     * @param $request
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function addBanner($request,BannerRepository $repository): JsonResponse
    {
        if(count($repository->all())>=6){
            return $this->Json('banner添加失败',null,HttpCode::HTTP_TYPE_ERROR,false,'banner最多只能添加6个');
        }
        $name='banner'.Carbon::now()->getPreciseTimestamp(3);
        Image::make(file_get_contents($request->file('img')->getRealPath()))->save('images/banner/'.$name.'.jpg');
        $data=$request->all();
        $data['path']='images/banner/'.$name.'.jpg';
        if($repository->create($data)){
            return $this->Json('添加成功');
        }
        return $this->Json('添加失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }

    /**
     * 修改banner
     * @param $request
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function updateBanner($request,BannerRepository $repository): JsonResponse
    {
        $data=$request->all();
        if($request->file('img')!=null){
            $name='banner'.Carbon::now()->getPreciseTimestamp(3);
            Image::make(file_get_contents($request->file('img')->getRealPath()))->save('images/banner/'.$name.'.jpg');
            $data['path']='images/banner/'.$name.'.jpg';
            $path=$repository->findById($request->id)->path;
            Storage::delete($path);
        }else{
            $path=$repository->findById($request->id)->path;
            $data['path']=$path;
        }
        if($repository->update($request->id,$data)){
            return $this->Json('修改成功');
        }
        return $this->Json('修改失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }

    /**
     * 删除Banner
     * @param $request
     * @param BannerRepository $repository
     * @return JsonResponse
     */
    public function deleteBanner($request,BannerRepository $repository): JsonResponse
    {

        Storage::delete($repository->findById($request->id)->path);
        if($repository->delete($request->id)){
            return $this->Json('删除成功');
        }
        return $this->Json('删除失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }
}
