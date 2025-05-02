<?php

namespace App\Jobs;

use App\Contracts\NeoDataAnalysisCollectionInterface;
use App\Models\NeoDataAnalysis;
use App\Models\NeoObject;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class RunDailyNeoAnalysisJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public readonly Carbon $date
    ) {}

    public function handle(NeoDataAnalysisCollectionInterface $analysisCollection): void
    {
        $neoObjects = NeoObject::with('closeApproaches')->whereBetween('created_at', [
            $this->date->copy()->startOfDay(),
            $this->date->copy()->endOfDay(),
        ])->get();

        $collection = $analysisCollection->make($neoObjects->all());


        $analysis = NeoDataAnalysis::create([
            'total_neo_count' => $collection->totalNeoCount(),
            'avg_estimated_diameter_min' => $collection->avgEstimatedDiameterMin(),
            'avg_estimated_diameter_max' => $collection->avgEstimatedDiameterMax(),
            'max_velocity' => $collection->maxVelocity(),
            'min_miss_distance' => $collection->minMissDistance(),
        ]);


        $analysis->neoObjects()->attach($neoObjects->pluck('id'));
    }
}
