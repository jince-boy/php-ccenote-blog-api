<?php
namespace App\Services\BackService;
use App\Repositories\PartnerRepository;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PartnerService extends BaseService{

    /**
     * 友情链接列表
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function getPartnerList(PartnerRepository $repository): JsonResponse
    {
        $list=$repository->all()->map(function ($context){
            if($context->path!==null){
                $context->path=asset($context->path);
            }
            return $context;
        });
        return $this->Json('ok',$list);
    }

    /**
     * 获取友情链接
     * @param $request
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function getPartner($request,PartnerRepository $repository): JsonResponse
    {
        if(!$repository->exists('id',$request->id)){
            return $this->Json('获取失败',null,HttpCode::HTTP_TYPE_ERROR,false,'友情链接id不存在');
        }
        $partner=$repository->findById($request->id);
        if($partner->path!==null){
            $partner->path=asset($partner->path);
        }
        return $this->Json('ok',$partner);
    }
    /**
     * 添加友情链接
     * @param $request
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function addPartner($request,PartnerRepository $repository): JsonResponse
    {
        $name='partner'.Carbon::now()->getPreciseTimestamp(3);
        if($request->img!==null){
            Image::make(file_get_contents($request->file('img')->getRealPath()))->save('images/partner/'.$name.'.jpg');
            $data=$request->all();
            $data['path']='images/partner/'.$name.'.jpg';
        }else{
            $data=$request->all();
        }
        if($repository->create($data)){
            return $this->Json('添加成功');
        }
        return $this->Json('添加失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }

    /**
     * 修改友情链接
     * @param $request
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function updatePartner($request,PartnerRepository $repository): JsonResponse
    {
        $data=$request->all();
        if($request->file('img')!=null){
            $name='partner'.Carbon::now()->getPreciseTimestamp(3);
            Image::make(file_get_contents($request->file('img')->getRealPath()))->save('images/partner/'.$name.'.jpg');
            $data['path']='images/partner/'.$name.'.jpg';
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
     * 删除友情链接
     * @param $request
     * @param PartnerRepository $repository
     * @return JsonResponse
     */
    public function deletePartner($request,PartnerRepository $repository): JsonResponse
    {
        Storage::delete($repository->findById($request->id)->path);
        if($repository->delete($request->id)){
            return $this->Json('删除成功');
        }
        return $this->Json('删除失败',null,HttpCode::HTTP_INTERNAL_SERVER_ERROR,false,'服务器错误');
    }
}
