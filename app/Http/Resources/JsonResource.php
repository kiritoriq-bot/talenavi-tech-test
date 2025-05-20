<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource as Resource;
use Illuminate\Http\Request;

class JsonResource extends Resource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  Request  $request
     */
    public function with($request): array
    {
        return ['success' => true];
    }
}