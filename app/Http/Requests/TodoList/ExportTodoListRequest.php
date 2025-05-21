<?php

namespace App\Http\Requests\TodoList;

use App\Http\Requests\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class ExportTodoListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'nullable',
                'string',
            ],
            'assignee' => [
                'nullable',
                'string'
            ],
            'due_date' => [
                'nullable',
                'array'
            ],
            'due_date.start' => [
                'nullable',
                'date_format:Y-m-d',
            ],
            'due_date.end' => [
                'nullable',
                'date_format:Y-m-d',
                Rule::requiredIf(function () {
                    return $this->input('due_date') &&
                        Arr::exists($this->input('due_date'), 'start');
                })
            ],
            'time_tracked' => [
                'nullable',
                'array'
            ],
            'time_tracked.min' => [
                'nullable',
                'numeric',
            ],
            'time_tracked.max' => [
                'nullable',
                'numeric',
                Rule::requiredIf(function () {
                    return $this->input('time_tracked') &&
                        Arr::exists($this->input('time_tracked'), 'min');
                })
            ],
            'status' => [
                'nullable',
                'string'
            ],
            'priority' => [
                'nullable',
                'string'
            ]
        ];
    }
}