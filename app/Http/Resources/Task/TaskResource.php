<?php

namespace App\Http\Resources\Task;

use App\Enums\TaskStatusesEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user->name,
            'file_path' => Storage::disk('public')->url($this->file->path),
            'file_title' => $this->file->title,
            'status' => TaskStatusesEnum::from($this->status)->description(),
            'failedRows' => $this->failedRows->count() ?
                route('tasks.task.failed-rows', ['task' => $this->id])
                : null,
        ];
    }
}
