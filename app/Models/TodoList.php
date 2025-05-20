<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'status' => Status::class,
        'priority' => Priority::class,
    ];
}
