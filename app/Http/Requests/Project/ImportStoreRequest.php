<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ImportStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        if (!in_array($this->file('file')->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            throw ValidationException::withMessages(['The file must be an excel file']);
        }

        return [
            'file' => ['required', 'file'],
        ];
    }
}
