<?php

namespace App\DataTransferObjects\TodoList;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class CreateTodoListData extends Data
{
    public function __construct(
        public readonly string $title,
        public readonly string | Optional | null $assignee,
        public readonly string $due_date,
        public readonly string | Optional | null $time_tracked,
        public readonly string | Optional | null $status,
        public readonly string $priority,
    )
    {
    }
}