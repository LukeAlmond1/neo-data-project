<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \App\Models\NeoObject;

/** @mixin NeoObject */
class NeoObjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference_id' => $this->reference_id,
            'name' => $this->name,
            'absolute_magnitude' => $this->absolute_magnitude,
            'estimated_diameter_min' => $this->estimated_diameter_min,
            'estimated_diameter_max' => $this->estimated_diameter_max,
            'is_hazardous' => $this->is_hazardous,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'close_approaches' => CloseApproachDataResource::collection($this->whenLoaded('closeApproaches')),
        ];
    }
}
