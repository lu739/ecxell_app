<?php

namespace App\Http\Controllers;

use App\Http\Resources\FailedRow\FailedRowResource;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = TaskResource::collection(
            Task::query()
                ->with('user', 'file')
                ->paginate(4));

        return inertia()->render('Task/Index', compact('tasks'));
    }
    public function failedRows(Task $task)
    {
        $failedRows = FailedRowResource::collection($task->failedRows()->paginate(20));

        return inertia()->render('Task/FailedRows', compact('failedRows'));
    }
}
