<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\NeoDataAnalysis;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin NeoDataAnalysis */
class NeoDataAnalysisResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'analysis_date' => $this->created_at,
            'total_neo_count' => $this->total_neo_count,
            'avg_estimated_diameter_min' => $this->avg_estimated_diameter_min,
            'avg_estimated_diameter_max' => $this->avg_estimated_diameter_max,
            'max_velocity' => $this->max_velocity,
            'min_miss_distance' => $this->min_miss_distance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
