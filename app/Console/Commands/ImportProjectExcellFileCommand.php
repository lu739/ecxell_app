<?php

namespace App\Console\Commands;

use App\Enums\TaskStatusesEnum;
use App\Imports\ProjectFileDynamicImport;
use App\Imports\ProjectFileImport;
use App\Jobs\ImportProjectExcellFileJob;
use App\Models\File;
use App\Models\Task;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcellFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import excell file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $file = File::query()->first(); // для теста просто берем первый файл
        //
        // $task = Task::query()->where('file_id', $file->id)->first();
        // Excel::import(new ProjectFileImport($task), $file->path, 'public');
        //
        // dispatch(new ImportProjectExcellFileJob(
        //         $file,
        //         Task::query()->where('file_id', $file->id)->first()
        //     )
        // );

        $file = File::query()->latest()->first(); // для теста просто берем последний файл
        $task = Task::query()->where('file_id', $file->id)->first();
        try {
            Excel::import(new ProjectFileDynamicImport($task), $file->path, 'public');

            $task->update(['status' => TaskStatusesEnum::SUCCESS->value]);
        } catch (\Throwable $exception) {
            throw $exception;
        }
    }
}
