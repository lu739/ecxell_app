<?php

namespace App\Imports;

use App\Actions\Project\CreateFailedRowsAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\Dto\CreateProjectDto;
use App\Enums\TaskStatusesEnum;
use App\Enums\TitleKeysEnum;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProjectFileImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, WithChunkReading
{

    public function __construct(
        private Task $task,
        private Collection $types = new Collection,
    )
    {
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): int|\Exception
    {
        $this->types = $this->getTypes();

        foreach ($collection as $row) {

            if (!isset($row[TitleKeysEnum::TITLE->excellKey()])) {
                throw new \Exception('title is not set');
            }

            $collection = collect();

            foreach ($row as $key => $value) {
                if (!isset($key)) {
                    break;
                }

                if (!isset($value)) {
                    continue;
                }

                if ($key === TitleKeysEnum::TYPE_ID->excellKey()) {
                    $value = $this->getTypeId($value);
                }

                $collection->put($key, $value);
            }

            $dto = CreateProjectDto::fromCollection($collection);
            $action = new CreateProjectAction();

            try {
                $action($dto);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return Command::SUCCESS;
    }

    private function getTypes(): Collection
    {
        return Type::all()->pluck('id', 'title');
    }

    private function getTypeId($value): int
    {
        if (isset($this->types[$value])) {
            return $this->types[$value];
        }

        $newType = Type::create([
            'title' => $value
        ]);

        $this->types[$value] = $newType->id;

        return $newType->id;
    }

    public function rules(): array
    {
        return [
            TitleKeysEnum::TYPE_ID->excellKey() => 'required|string',
            TitleKeysEnum::TITLE->excellKey() => 'required|string',
            TitleKeysEnum::DATE_CREATED->excellKey() => 'required|integer',
            TitleKeysEnum::IS_CHAIN->excellKey() => 'nullable|string',
            TitleKeysEnum::WORKER_COUNT->excellKey() => 'nullable|integer',
            TitleKeysEnum::HAS_OUTSOURCE->excellKey() => 'nullable|string',
            TitleKeysEnum::HAS_INVESTORS->excellKey() => 'nullable|string',
            TitleKeysEnum::DATE_DEADLINE->excellKey() => 'nullable|integer',
            TitleKeysEnum::IS_ON_TIME->excellKey() => 'nullable|string',
            TitleKeysEnum::PAYMENT_FIRST_STEP->excellKey() => 'nullable|integer',
            TitleKeysEnum::PAYMENT_SECOND_STEP->excellKey() => 'nullable|integer',
            TitleKeysEnum::PAYMENT_THIRD_STEP->excellKey() => 'nullable|integer',
            TitleKeysEnum::PAYMENT_FOURTH_STEP->excellKey() => 'nullable|integer',
            TitleKeysEnum::DATE_CONTRACT->excellKey() => 'required|integer',
            TitleKeysEnum::SERVICE_COUNT->excellKey() => 'nullable|integer',
            TitleKeysEnum::COMMENT->excellKey() => 'nullable|string',
            TitleKeysEnum::EFFICIENCY->excellKey() => 'nullable|numeric',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        $map = [];

        foreach ($failures as $failure) {
            foreach ($failure->errors() as $error) {
                $map[] = [
                    'key' => $failure->attribute(),
                    'message' => $error,
                    'row' => $failure->row(),
                    'task_id' => $this->task->id,
                ];
            }
        }

        if (count($map) > 0) {
            $this->task->update(['status' => TaskStatusesEnum::WITH_FAILED_ROWS->value]);
            (new CreateFailedRowsAction())($map);
        }

        return Command::FAILURE;
    }

    public function customValidationMessages()
    {
        return [
            'tip.required' => 'Необходимо указать тип проекта',
            'naimenovanie.required' => 'Необходимо указать название проекта',
            'data_sozdaniia.required' => 'Необходимо указать дату создания проекта',
            'podpisanie_dogovora.required' => 'Необходимо указать дату подписания договора',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
