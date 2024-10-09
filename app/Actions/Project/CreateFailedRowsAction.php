<?php

namespace App\Actions\Project;

use App\Actions\Project\Dto\CreateFailedRowsDto;
use App\Models\FailedRow;

class CreateFailedRowsAction
{
    public function __invoke(array $rows)
    {
        foreach ($rows as $row) {

            $dto = CreateFailedRowsDto::fromArray($row);

            FailedRow::query()->updateOrCreate(
                $dto->toUpdateArray(),
                $dto->toArray()
            );
        }
    }
}
