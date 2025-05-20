<?php

namespace App\DataTransferObjects\TodoList;

use Spatie\LaravelData\Data;

class FetchTodoListChartData extends Data
{
    public function __construct(
        public readonly string $type,
    )
    {
    }
}