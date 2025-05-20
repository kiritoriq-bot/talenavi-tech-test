<?php

namespace App\Actions\TodoList;

use App\Actions\Action;
use App\DataTransferObjects\TodoList\FetchTodoListChartData;
use App\Enums\Priority;
use App\Enums\Status;
use App\Models\TodoList;
use Illuminate\Support\Facades\DB;

class FetchTodoListChartAction extends Action
{
    public function execute(FetchTodoListChartData $data)
    {
        if ($data->type == 'status') {
            return $this->resolveStatusType();
        }

        if ($data->type == 'priority') {
            return $this->resolvePriorityType();
        }

        if ($data->type == 'assignee') {
            return $this->resolveAssigneeType();
        }
    }

    protected function resolveStatusType()
    {
       $statuses = Status::getValues();
       $data = [];

       foreach ($statuses as $status) {
           $data[$status] = TodoList::query()
               ->where('status', $status)
               ->count();
       }

       return response()->json([
           'success' => true,
           'status_summary' => $data,
       ]);
    }

    protected function resolvePriorityType()
    {
        $priorities = Priority::getValues();
        $data = [];

        foreach ($priorities as $priority) {
            $data[$priority] = TodoList::query()
                ->where('priority', $priority)
                ->count();
        }

        return response()->json([
            'success' => true,
            'priority_summary' => $data,
        ]);
    }

    protected function resolveAssigneeType()
    {
        $results = DB::select('
            WITH _assignees AS (
                SELECT assignee
                FROM todo_lists
                GROUP BY assignee
            )
            , _total_todos AS (
                SELECT assignee, COUNT(id) as total
                FROM todo_lists
                WHERE assignee IN (SELECT assignee FROM _assignees)
            )
            , _total_pending_todos AS (
                SELECT assignee, COUNT(id) as total
                FROM todo_lists
                WHERE assignee IN (SELECT assignee FROM _assignees)
                AND status = "pending"
            )
            , _total_timetracked_completed_todos AS (
            	SELECT assignee, SUM(time_tracked) as total
                FROM todo_lists
                WHERE assignee IN (SELECT assignee FROM _assignees)
                GROUP BY assignee
                AND status = "completed"
            )
            , _merge AS (
                SELECT
                    tt.assignee, tt.total as total_todos, tpt.total as total_pending_todos, ttcd.total as total_timetracked
                FROM _total_todos tt
                JOIN _total_pending_todos tpt ON true
                JOIN _total_timetracked_completed_todos ttcd ON true
            )
            SELECT assignee, total_todos, total_pending_todos, total_timetracked FROM _merge
        ');
        $data = [];

        foreach ($results as $result) {
            $data[$result->assignee] = [
                'total_todos' => $result->total_todos,
                'total_pending_todos' => $result->total_pending_todos,
                'total_timetracked_completed_todos' => $result->total_timetracked,
            ];
        }

        return response()->json([
            'success' => true,
            'assignee_summary' => $data,
        ]);
    }
}