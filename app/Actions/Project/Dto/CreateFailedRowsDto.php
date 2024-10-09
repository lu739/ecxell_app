<?php

namespace App\Actions\Project\Dto;

use App\Enums\TitleKeysEnum;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CreateFailedRowsDto
{
    public function __construct(
        private int $task_id,
        private string $key,
        private string $message,
        private int $row,
    )
    {
    }


    public static function fromArray(array $array): self
    {
        return new self(
            task_id: $array['task_id'],
            key: TitleKeysEnum::getEnumKeyFromRussianValue($array['key']),
            message: $array['message'],
            row: $array['row'],
        );
    }

    public function toUpdateArray(): array
    {
        return [
            'row' => $this->getRow(),
            'task_id' => $this->getTaskId(),
            'key' => $this->getKey(),
        ];
    }

    public function toArray(): array
    {
        return [
            ...$this->toUpdateArray(),
            'message' => $this->getMessage(),
        ];
    }

    public function getTaskId(): int
    {
        return $this->task_id;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRow(): int
    {
        return $this->row;
    }
}
