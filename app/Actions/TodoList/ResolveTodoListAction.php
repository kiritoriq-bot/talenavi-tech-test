<?php

namespace App\Actions\TodoList;

use App\Actions\Action;
use App\DataTransferObjects\TodoList\CreateTodoListData;
use App\Enums\Status;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ResolveTodoListAction extends Action
{
    public function execute(CreateTodoListData $data): ?Model
    {
        $createData = $data->toArray();

        if (!Arr::exists($createData, 'status')) {
            $createData['status'] = Status::Pending;
        }

        if (!Arr::exists($createData, 'time_tracked')) {
            $createData['time_tracked'] = 0;
        }

        return TodoList::query()
            ->create($createData);
    }
}