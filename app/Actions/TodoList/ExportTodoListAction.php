<?php

namespace App\Actions\TodoList;

use App\Actions\Action;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportTodoListAction extends Action
{
    public function execute(array $params)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getSheet(0);

        $sheet->setCellValue('A1', 'title');
        $sheet->setCellValue('B1', 'assignee');
        $sheet->setCellValue('C1', 'due_date');
        $sheet->setCellValue('D1', 'time_tracked');
        $sheet->setCellValue('E1', 'status');
        $sheet->setCellValue('F1', 'priority');

        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('99e6b3');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER);

        $todos = $this->resolveData($params);
        $row = 2;
        $totalTimeTracked = 0;

        foreach ($todos as $todo) {
            $sheet->setCellValue('A' . $row, $todo->title);
            $sheet->setCellValue('B' . $row, $todo->assignee);
            $sheet->setCellValue('C' . $row, Date::PHPToExcel($todo->due_date));
            $sheet->setCellValue('D' . $row, $todo->time_tracked);
            $sheet->setCellValue('E' . $row, $todo->status->value);
            $sheet->setCellValue('F' . $row, $todo->priority->value);

            $sheet->getStyle('C' . $row)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);

            $sheet->getStyle('D' . $row)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_NUMBER_00);

            $totalTimeTracked += $todo->time_tracked;

            $row++;
        }

        foreach (range('A', 'F') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->getStyle('A1:F' . $row-1)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black
                ],
            ],
        ]);

        $currentRow = $row+1;
        $sheet->setCellValue('A' . $currentRow, 'Total number of todos:');
        $sheet->setCellValue('B' . $currentRow, count($todos));
        $sheet->setCellValue('A' . $currentRow+1, 'Total time_tracked accross all todos:');
        $sheet->setCellValue('B' . $currentRow+1, $totalTimeTracked);

        $writer = new Xlsx($spreadsheet);
        $filename = 'export_todos_' . time() . '.xlsx';

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return response($excelOutput, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    }

    protected function resolveData(array $params)
    {
        $todos = TodoList::query()
            ->latest()
            ->when(
                (Arr::exists($params, 'title') && filled (Arr::get($params, 'title'))),
                fn (Builder $query) => $query->where('title', 'like',  '%'. $params['title'] .'%')
            );

        if (Arr::exists($params, 'assignee') && filled (Arr::get($params, 'assignee'))) {
            $assignees = explode(',',  $params['assignee']);

            $todos = $todos->whereIn('assignee', $assignees);
        }

        if (Arr::exists($params, 'status') && filled (Arr::get($params, 'status'))) {
            $statuses = explode(',',  $params['status']);

            $todos = $todos->whereIn('status', $statuses);
        }

        if (Arr::exists($params, 'priority') && filled (Arr::get($params, 'priority'))) {
            $priorities = explode(',',  $params['priority']);

            $todos = $todos->whereIn('priority', $priorities);
        }

        if (Arr::exists($params, 'due_date')) {
            $dateStart =  Arr::get($params['due_date'], 'start');
            $dateEnd =  Arr::get($params['due_date'], 'end');

            if (filled ($dateStart) && filled ($dateEnd)) {
                $todos = $todos->whereBetween('due_date', [$dateStart, $dateEnd]);
            }
        }

        if (Arr::exists($params, 'time_tracked')) {
            $min =  Arr::get($params['time_tracked'], 'min');
            $max =  Arr::get($params['time_tracked'], 'max');

            if (filled ($min) && filled ($max)) {
                $todos = $todos->where('time_tracked', '>=', $min)
                    ->where('time_tracked', '<=', $max);
            }
        }

        return $todos->get();
    }
}