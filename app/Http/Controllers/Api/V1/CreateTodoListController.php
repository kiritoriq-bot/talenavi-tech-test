<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\TodoList\ResolveTodoListAction;
use App\DataTransferObjects\TodoList\CreateTodoListData;
use App\Http\Requests\TodoList\CreateTodoListRequest;
use App\Http\Resources\TodoList\Resource;

class CreateTodoListController
{
    public function __invoke(CreateTodoListRequest $request)
    {
        $created = ResolveTodoListAction::resolve()
            ->execute(
                data: CreateTodoListData::from($request->validated())
            );

        return new Resource($created);
    }
}