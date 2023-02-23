<?php

namespace App\Services\Project;

use Illuminate\Pagination\LengthAwarePaginator;

class LengthAwarePaginatorService extends LengthAwarePaginator
{
    /**
     * 自定义分页展示内容
     * @return array
     */
    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage(),
            'data' => $this->items->toArray(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];
    }
}
