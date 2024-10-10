<?php

namespace App\Actions\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class CreateFileAction
{
    public function __invoke($file): File
    {
        $path = Storage::disk('public')->put('files', $file);

        $file = File::create([
            'title' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getClientMimeType(),
        ]);

        return $file;
    }
}
