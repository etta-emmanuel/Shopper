<?php

namespace App\Services;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;

class SaveImageService
{
    public function handle(
        Model $imageable, UploadedFile $file, array $attributes = [], string $disk = 'public',
    ): Image
    {
        if (! method_exists($imageable, 'images')) {
            throw new InvalidArgumentException('The given :model does not support images.');
        }

        $directory = $attributes['directory'] ?? $this->directoryFor($imageable);
        $path = $file->store($directory, $disk);

        return $imageable->images()->create([
            'img_url' => Storage::disk($disk)->url($path),
            'alt_text' => $attributes['alt_text'] ?? null,
            'is_default' => $attributes['is_default'] ?? false,
            'sort_order' => $attributes['sort_order'] ?? 0,
        ]);
    }

    protected function directoryFor(Model $imageable): string
    {
        $type = Str::plural(Str::snake(class_basename($imageable)));

        return "images/{$type}/{$imageable->getKey()}";
    }
}
