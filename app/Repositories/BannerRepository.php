<?php
namespace App\Repositories;


use App\Models\Banners;

class BannerRepository extends BaseRepository{

    public function __construct(Banners $model)
    {
        parent::__construct($model);
    }

}
