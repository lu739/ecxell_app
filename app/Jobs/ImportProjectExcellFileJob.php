<?php

namespace App\Jobs;

use App\Enums\TaskStatusesEnum;
use App\Imports\ProjectFileImport;
use App\Models\File;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ImportProjectExcellFileJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private File $file,
        private Task $task
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Excel::import(new ProjectFileImport($this->task), $this->file->path, 'public');

            $this->task->update(['status' => TaskStatusesEnum::SUCCESS->value]);
        } catch (\Throwable $exception) {
            $this->fail($exception);
        }
    }

    public function fail($exception = null)
    {
        $this->task->update(['status' => TaskStatusesEnum::FAIL->value]);
    }
}
