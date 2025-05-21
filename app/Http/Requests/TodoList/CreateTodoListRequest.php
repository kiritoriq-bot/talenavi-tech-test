<?php

namespace App\Http\Requests\TodoList;

use App\Enums\Priority;
use App\Enums\Status;
use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class CreateTodoListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'assignee' => [
                'nullable',
                'string',
                'max:255'
            ],
            'due_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today'
            ],
            'time_tracked' => [
                'nullable',
                'numeric',
            ],
            'status' => [
                'nullable',
                Rule::in(Status::getValues())
            ],
            'priority' => [
                'required',
                Rule::in(Priority::getValues())
            ]
        ];
    }
}