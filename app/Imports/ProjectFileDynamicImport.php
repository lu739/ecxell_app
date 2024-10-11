<?php

namespace App\Imports;

use App\Actions\Project\CreateFailedRowsAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\Dto\CreateDynamicProjectDto;
use App\Enums\TaskStatusesEnum;
use App\Enums\TitleKeysEnum;
use App\Models\Task;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Validators\Failure;

class ProjectFileDynamicImport implements ToCollection, SkipsOnFailure, WithChunkReading, WithValidation, WithStartRow, WithEvents
{
    use RegistersEventListeners;
    private const STATIC_ROWS = 12;
    private static array $headings;

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
            if (!isset($row[1])) {
                throw new \Exception('title is not set');
            }

            $maps = $this->mapRow($row);
            $collection = collect();

            foreach ($maps['static'] as $key => $value) {
                $collection->put($key, $value);
            }

            $dynamicHeadings = $this->mapRow(self::$headings)['dynamic']->toArray();
            $dynamicValues = $maps['dynamic']->toArray();
            $mergedPayments = [];

            foreach ($dynamicHeadings as $key => $value) {
                if (array_key_exists($key, $dynamicValues)) {
                    $mergedPayments[$value] = $dynamicValues[$key];
                }
            }

            $payments = json_encode($mergedPayments);

            $collection->put(TitleKeysEnum::JSON_PAYMENTS->value, $payments);

            $dto = CreateDynamicProjectDto::fromCollection($collection);
            $action = new CreateProjectAction();

            try {
                $action($dto);
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        return Command::SUCCESS;
    }

    public function mapRow($row): array
    {
        $static = collect();
        $dynamic = collect();

        foreach ($row as $key => $value) {
            if (!isset($key)) {
                break;
            }
            if (!isset($value)) {
                continue;
            }

            if ($key === TitleKeysEnum::TYPE_ID->excellNumericKey()) {
                $value = $this->getTypeId($value);
            }

            if ($key > self::STATIC_ROWS) {
                $dynamic->put($key, $value);
            } else {
                $static->put($key, $value);
            }
        }

        return [
            'static' => $static,
            'dynamic' => $dynamic
        ];
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

    public function chunkSize(): int
    {
        return 1000;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function rules(): array
    {
        return [
            TitleKeysEnum::TYPE_ID->excellNumericKey() => 'required|string',
            TitleKeysEnum::TITLE->excellNumericKey() => 'required|string',
            TitleKeysEnum::DATE_CREATED->excellNumericKey() => 'required|integer',
            TitleKeysEnum::IS_CHAIN->excellNumericKey() => 'nullable|string',
            TitleKeysEnum::WORKER_COUNT->excellNumericKey() => 'nullable|integer',
            TitleKeysEnum::HAS_OUTSOURCE->excellNumericKey() => 'nullable|string',
            TitleKeysEnum::HAS_INVESTORS->excellNumericKey() => 'nullable|string',
            TitleKeysEnum::DATE_DEADLINE->excellNumericKey() => 'nullable|integer',
            TitleKeysEnum::IS_ON_TIME->excellNumericKey() => 'nullable|string',
            TitleKeysEnum::DATE_CONTRACT->excellNumericKey() => 'required|integer',
            TitleKeysEnum::SERVICE_COUNT->excellNumericKey() => 'nullable|integer',
            TitleKeysEnum::COMMENT->excellNumericKey() => 'nullable|string',
            TitleKeysEnum::EFFICIENCY->excellNumericKey() => 'nullable|numeric',
        ];
    }

    public static function beforeSheet(BeforeSheet $event)
    {
        self::$headings = $event->getSheet()->getDelegate()->toArray()[0];
    }
}
