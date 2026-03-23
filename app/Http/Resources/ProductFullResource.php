<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductFullResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = $this->images
            ->sortBy('sort_order')
            ->values()
            ->map(fn ($image) => [
                'alt_text' => $image->alt_text,
                'full' => $image->full,
                'medium' => $image->medium,
                'thumbnail' => $image->thumbnail,
            ]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'base_price' => (float) $this->base_price,
            'discount' => (float) $this->discount,
            'price' => max((float) $this->base_price - (float) $this->discount, 0),
            'src' => $images->first()['full'] ?? null,
            'images' => $images,
        ];
    }
}
