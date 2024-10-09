<?php

namespace App\Console\Commands;

use App\Jobs\ImportProjectExcellFileJob;
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
        dispatch(new ImportProjectExcellFileJob('files/ZmzURVqBRchTtx38mJrChH156YJa0r81hE6ghcid.xlsx'));
    }
}
