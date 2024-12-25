<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OperationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $lastPageNum = ceil($this->total() / $this->perPage());

        return [
            'data' => $this->collection,
            'total' => $this->total(),
            'pagination' => [
                'first_page_url' => $this->url(1),
                'last_page' => $lastPageNum,
                'last_page_url' => $this->url($lastPageNum),
                'next_page_url' => $this->nextPageUrl(),
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
            ]
        ];
    }
}
