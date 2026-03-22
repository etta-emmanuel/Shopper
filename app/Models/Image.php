<?php

namespace App\Models;

use Database\Factories\ImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['img_url', 'alt_text', 'sort_order'])]
class Image extends Model
{
    /** @use HasFactory<ImageFactory> */
    use HasFactory;

    protected $guarded = [];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transform('thumbnail'),
        );
    }

    protected function medium(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transform('medium'),
        );
    }

    protected function full(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transform('full'),
        );
    }
    public function transform(string $preset): string
    {
        $source = $this->getAttributeFromArray('img_url');

        return match ($preset) {
            'thumbnail' => $source,
            'medium' => $source,
            'full' => $source,
            default => $source,
        };
    }
}
