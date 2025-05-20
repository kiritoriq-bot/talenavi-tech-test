<?php

namespace App\Http\Resources\TodoList;

use App\Http\Resources\ResourceCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class Collection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param $request
     * @return AnonymousResourceCollection
     */
    public function toArray($request): AnonymousResourceCollection
    {
        return Resource::collection($this->collection);
    }
}