<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\TodoList\FetchTodoListChartAction;
use App\DataTransferObjects\TodoList\FetchTodoListChartData;
use App\Http\Requests\TodoList\FetchTodoListChartRequest;

class FetchTodoListChartController
{
    public function __invoke(FetchTodoListChartRequest $request)
    {
        return FetchTodoListChartAction::resolve()
            ->execute(
                data: FetchTodoListChartData::from($request->validated())
            );
    }
}