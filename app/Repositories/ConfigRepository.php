<?php

namespace App\Repositories;

use App\Models\Configs;

class ConfigRepository extends BaseRepository
{
    public function __construct(Configs $model)
    {
        parent::__construct($model);
    }
}
