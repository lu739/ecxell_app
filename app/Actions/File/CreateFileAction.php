<?php

namespace App\Actions\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class CreateFileAction
{
    public function __invoke($file): string
    {
        $path = Storage::disk('public')->put('files', $file);

        File::create([
            'title' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
        ]);

        return $path;
    }
}
