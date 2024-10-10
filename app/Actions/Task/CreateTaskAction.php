<?php

namespace App\Actions\Task;

use App\Enums\TaskStatusesEnum;
use App\Models\Task;

class CreateTaskAction
{
    public function __invoke($file): Task
    {
        $task = Task::create([
            'user_id' => auth()->id(),
            'file_id' => $file->id,
            'status' => TaskStatusesEnum::NEW->value
        ]);

        return $task;
    }
}
