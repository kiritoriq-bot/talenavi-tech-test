<?php

use App\Http\Controllers\Api\V1\CreateTodoListController;
use App\Http\Controllers\Api\V1\FetchTodoListChartController;
use App\Http\Controllers\Api\V1\ExportTodoListController;
use Illuminate\Support\Facades\Route;

Route::prefix('todo-list')
    ->middleware(['throttle:public'])
    ->group(function () {
       Route::post('', CreateTodoListController::class);
       Route::get('export', ExportTodoListController::class);
       Route::get('chart', FetchTodoListChartController::class);
    });