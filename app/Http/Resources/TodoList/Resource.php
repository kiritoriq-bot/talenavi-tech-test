<?php

namespace App\Http\Resources\TodoList;

use App\Http\Resources\JsonResource;
use Illuminate\Http\Request;

class Resource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'assignee' => $this->assignee,
            'due_date' => $this->due_date,
            'time_tracked' => $this->time_tracked,
            'status' => $this->status,
            'priority' => $this->priority,
            'created_at' => $this->created_at,
        ];
    }
}