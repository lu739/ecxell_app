<?php

namespace App\Actions\Project;

use App\Actions\Project\Dto\CreateProjectDto;
use App\Models\Project;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class CreateProjectAction
{
    public function __invoke(CreateProjectDto $dto): void
    {
        try {
            DB::beginTransaction();

                Project::query()->updateOrCreate([
                    'type_id' => $dto->getTypeId(),
                    'title' => $dto->getTitle(),
                    'date_created' => $dto->getDateCreated(),
                    'date_contract' => $dto->getDateContract(),
                ],
                    $dto->toArray()
                );

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}
