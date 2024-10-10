<?php

namespace App\Console\Commands;

use App\Jobs\ImportProjectExcellFileJob;
use App\Models\File;
use App\Models\Task;
use Illuminate\Console\Command;

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
        $file = File::query()->first();
        dispatch(new ImportProjectExcellFileJob(
                $file,
                Task::query()->where('file_id', $file->id)->first()
            )
        );
    }
}
