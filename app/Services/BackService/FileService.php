<?php

namespace App\Services\BackService;

use App\Models\Configs;
use App\Services\BaseService;
use App\Traits\HttpCode;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class FileService extends BaseService
{
    /**
     * 删除文件
     * @param $request
     * @return JsonResponse
     */
    public function deleteFile($request){
        if($request->type=="article") {
            Storage::disk('images')->delete($request->names);
        }else if($request->type="file"){
            Storage::disk('file')->delete($request->names);
        }else{
            return $this->Json('删除失败', null, HttpCode::HTTP_TYPE_ERROR, false, '参数类型有误');
        }
        return $this->Json('删除成功');
    }
    /**
     * 上传文件
     * @param $request
     * @return JsonResponse
     */
    public function uploadFile($request): JsonResponse
    {
        $filename=Carbon::now()->getPreciseTimestamp(3);
        $extension=$request->file('file')->extension();
        Storage::putFileAs('file',$request->file('file'),$filename.'.'.$extension);
        return $this->Json('上传成功');
    }
    /**
     * 获取文件列表
     * @param $request
     * @return JsonResponse
     */
    public function getFileList($request): JsonResponse
    {
        //"current_page": 1,当前页
        //"data": [],数据
        //"last_page": 1,最后一页
        //"per_page": 20,每页
        //"total": 0总数据
        if ($request->type != 'article' && $request->type != 'file') {
            return $this->Json('获取文件列表错误', null, HttpCode::HTTP_TYPE_ERROR, false, '参数类型有误');
        }
        $data = [];

        if ($request->page == null || $request->page == 0) {
            $request->offsetSet('page', 1);
        }
        if ($request->type == "article") {
            $data['url'] = asset('images') . '/';
            $fileArr = array_reverse(Storage::disk('images')->files('article'));
            $type = 'article';
            $path = 'images';
        } else {
            $data['url'] = asset('file') . '/';
            $fileArr = array_reverse(Storage::disk('file')->files());
            $type = 'file';
            $path = 'file';
        }
        $page = $this->Page($fileArr);
        $data['current_page'] = (int)$request->page;
        $data['data'] = [];
        $data['last_page'] = $page['lastPage'];
        $data['per_page'] = $page['perPage'];
        $data['total'] = $page['total'];
        if ($request->page == $page['lastPage']) {
            $length = $page['total'] % ($request->page * $page['perPage']);
            $length = $length == 0 ? $request->page *$page['perPage'] : $length;
        } else {
            $length = $request->page*$page['perPage'];
        }
        if ($request->page > $page['lastPage']) {
            return $this->Json('ok', $data);
        }
        $i = $request->page == 1 ? 0 : ($request->page -1)* $page['perPage'];
        do {
            try {
                $data['data'][] = [
                    'path' => $fileArr[$i],
                    'type' => $type,
                    'size' => $this->getSize(Storage::disk($path)->size($fileArr[$i])),
                    'time' => date('Y-m-d H:i:s', Storage::disk($path)->getTimestamp($fileArr[$i])),
                    'extension'=>File::extension($path.'/'.$fileArr[$i])
                ];
            } catch (FileNotFoundException $e) {

            }
            $i++;
        } while ($i < $length);
        return $this->Json('ok', $data);
    }

    /**
     * 获取分页
     * @param array $data
     * @return array
     */
    public function Page(array $data): array
    {
        $page = [];
        $back_page_num = Configs::find(1)->back_page_num;
        $data_num = count($data);
        if ($data_num % $back_page_num == 0) {
            $page['lastPage'] = floor($data_num / $back_page_num);
        } else {
            $page['lastPage'] = floor(($data_num / $back_page_num) + 1);
        }
        $page['perPage'] = $back_page_num;
        $page['total'] = $data_num;
        return $page;
    }

    /**
     * 获取文件大小
     * @param $filesize
     * @return string
     */
    public function getSize($filesize): string
    {
        if ($filesize >= 1073741824) {
            //转成GB
            $filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
        } elseif ($filesize >= 1048576) {
            //转成MB
            $filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
        } elseif ($filesize >= 1024) {
            //转成KB
            $filesize = round($filesize / 1024 * 100) / 100 . ' KB';
        } else {
            //不转换直接输出
            $filesize = $filesize . ' 字节';
        }
        return $filesize;
    }
}
