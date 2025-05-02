<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\CloseApproachData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin CloseApproachData */
class CloseApproachDataResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'close_approach_date_full' => $this->close_approach_date_full,
            'relative_velocity' => $this->relative_velocity,
            'miss_distance' => $this->miss_distance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
