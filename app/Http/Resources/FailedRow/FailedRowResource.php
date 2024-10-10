<?php

namespace App\Http\Resources\FailedRow;

use App\Enums\TitleKeysEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FailedRowResource extends JsonResource
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
            'task_id' => $this->task_id,
            'key' => $this->key . ' / ' . TitleKeysEnum::from($this->key)->excellKey(),
            'message' => $this->message,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
