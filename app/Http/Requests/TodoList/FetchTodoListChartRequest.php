<?php

namespace App\Http\Requests\TodoList;

use App\Http\Requests\FormRequest;

class FetchTodoListChartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => [
                'required',
                'in:status,priority,assignee'
            ]
        ];
    }
}