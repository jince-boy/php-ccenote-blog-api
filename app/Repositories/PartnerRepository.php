<?php
namespace App\Repositories;


use App\Models\Partners;

class PartnerRepository extends BaseRepository{

    public function __construct(Partners $model)
    {
        parent::__construct($model);
    }

}
