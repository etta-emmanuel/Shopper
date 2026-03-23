<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductLightResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $image = $this->images->sortBy('sort_order')->first();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => max((float) $this->base_price - (float) $this->discount, 0),
            'src' => $image?->medium,
        ];
    }
}
