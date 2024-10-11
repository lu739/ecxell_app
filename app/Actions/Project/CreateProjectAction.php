<?php

namespace App\Actions\Project;

use App\Actions\Project\Dto\CreateDynamicProjectDto;
use App\Actions\Project\Dto\CreateProjectDto;
use App\Models\Payment;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class CreateProjectAction
{
    public function __invoke(CreateProjectDto|CreateDynamicProjectDto $dto): void
    {
        try {
            DB::beginTransaction();

                $project = Project::query()->updateOrCreate([
                    'type_id' => $dto->getTypeId(),
                    'title' => $dto->getTitle(),
                    'date_created' => $dto->getDateCreated(),
                    'date_contract' => $dto->getDateContract(),
                ],
                    $dto->toArray()
                );

                if ($dto instanceof CreateDynamicProjectDto && !is_null($dto->getJsonPayments())) {
                    $payments = json_decode($dto->getJsonPayments(), true);

                    foreach ($payments as $key => $payment) {
                        Payment::query()->updateOrCreate([
                            'project_id' => $project->id,
                            'title' => $key,
                            'value' => $payment,
                        ],
                        [
                            'project_id' => $project->id,
                            'title' => $key,
                            'value' => $payment,
                        ]);
                    }
                }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw new \Exception($e->getMessage());
        }
    }
}
