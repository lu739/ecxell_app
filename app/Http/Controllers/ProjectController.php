<?php

namespace App\Http\Controllers;

use App\Actions\File\CreateFileAction;
use App\Actions\Task\CreateTaskAction;
use App\Http\Requests\Project\ImportStoreRequest;
use App\Jobs\ImportProjectExcellFileJob;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Project/Index');
    }

    public function import()
    {
        return Inertia::render('Project/Import');
    }

    public function importStore(ImportStoreRequest $request)
    {
        $data = $request->validated();

        $action = new CreateFileAction();
        $file = $action(($data['file']));

        $task = (new CreateTaskAction())($file);

        ImportProjectExcellFileJob::dispatch($file, $task);
    }
}
