<?php

namespace App\Exports;

use App\Models\TodoList;
use Maatwebsite\Excel\Concerns\FromCollection;

class TodoListExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TodoList::all();
    }
}
