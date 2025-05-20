<?php

use App\Http\Controllers\Api\V1\CreateTodoListController;
use Illuminate\Support\Facades\Route;

Route::prefix('todo-list')
    ->middleware(['throttle:public'])
    ->group(function () {
       Route::post('', CreateTodoListController::class);
    });