<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\TodoList\ExportTodoListAction;
use App\Http\Requests\TodoList\ExportTodoListRequest;

class ExportTodoListController
{
    public function __invoke(ExportTodoListRequest $request)
    {
        return ExportTodoListAction::resolve()
            ->execute($request->validated());
    }
}