<?php

namespace App\Http\Controllers\Api\FrontController;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarRequest;
use App\Repositories\AdminRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImagesController extends Controller
{
    /**
     * 图片资源，字节流
     * Handle the incoming request.
     * @param AvatarRequest $request
     * @param AdminRepository $userRepository
     * @return Response
     */
    public function __invoke(AvatarRequest $request, AdminRepository $userRepository)
    {
        $type=$request->type=='back'?'back/':'front/';
        if(Storage::disk('images')->exists('avatar/'.$type.$request->username.'.jpg')){
            $image=Image::make('images/avatar/'.$type.$request->username.'.jpg')->resize($request->spec,$request->spec)->encode('jpg',75);
        }else{
            $image=Image::make('images/avatar/avatar.jpg')->resize($request->spec,$request->spec)->encode('jpg',75);
        }
        $image=\Response::make($image);
        return $image->header('Content-Type','image/jpg');

    }
}
