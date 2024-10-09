<?php

namespace App\Imports;

use App\Actions\Project\CreateFailedRowsAction;
use App\Actions\Project\CreateProjectAction;
use App\Actions\Project\Dto\CreateProjectDto;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class ProjectFileImport implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private Collection $types;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $this->types = $this->getTypes();

        foreach ($collection as $row) {

            if (!isset($row['naimenovanie'])) {
                continue;
            }

            $collection = collect();

            foreach ($row as $key => $value) {
                if (!isset($value)) {
                    continue;
                }

                if ($key === 'tip') {
                    $value = $this->getTypeId($value);
                }

                $collection->put($key, $value);
            }

            $dto = CreateProjectDto::fromCollection($collection);
            $action = new CreateProjectAction();

            try {
                $action($dto);
            } catch (\Throwable $e) {
                throw new \Exception($e->getMessage());
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
            'tip' => 'required|string',
            'naimenovanie' => 'required|string',
            'data_sozdaniia' => 'required|integer',
            'setevik' => 'nullable|string',
            'kolicestvo_ucastnikov' => 'nullable|integer',
            'nalicie_autsorsinga' => 'nullable|string',
            'nalicie_investorov' => 'nullable|string',
            'dedlain' => 'nullable|integer',
            'sdaca_v_srok' => 'nullable|string',
            'vlozenie_v_pervyi_etap' => 'nullable|integer',
            'vlozenie_vo_vtoroi_etap' => 'nullable|integer',
            'vlozenie_v_tretii_etap' => 'nullable|integer',
            'vlozenie_v_cetvertyi_etap' => 'nullable|integer',
            'podpisanie_dogovora' => 'required|integer',
            'kolicestvo_uslug' => 'nullable|integer',
            'kommentarii' => 'nullable|string',
            'znacenie_effektivnosti' => 'nullable|numeric',
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
                    'task_id' => 1, // ToDo
                ];
            }
        }

        if (count($map) > 0) {
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
}
