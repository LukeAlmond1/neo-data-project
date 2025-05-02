<?php

namespace App\Repositories;

use App\Contracts\NeoWriteRepositoryInterface;
use App\Dtos\NasaCloseApproachData;
use App\Dtos\NasaNeoApi;
use App\Models\CloseApproachData;
use App\Models\NeoObject;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class NasaNeoWriteRepository implements NeoWriteRepositoryInterface
{
    /**
     * @throws Throwable
     */
    public static function storeBatch(Collection $neos): void
    {
        if ($neos->isEmpty()) {
            return;
        }

        try {
            DB::transaction(function () use ($neos) {
                $neos->map(function (NasaNeoApi $neo) {
                    $neoObject = NeoObject::updateOrCreate(
                        ['reference_id' => $neo->referenceId],
                        [
                            'name' => $neo->name,
                            'absolute_magnitude' => $neo->absoluteMagnitude,
                            'estimated_diameter_min' => $neo->estimatedDiameterMin,
                            'estimated_diameter_max' => $neo->estimatedDiameterMax,
                            'is_hazardous' => $neo->isHazardous,
                        ]
                    );

                    $neo->closeApproaches->each(function (NasaCloseApproachData $approach) use ($neoObject) {
                        CloseApproachData::updateOrCreate(
                            [
                                'neo_object_id' => $neoObject->id,
                                'close_approach_date_full' => $approach->closeApproachDateFull,
                            ],
                            [
                                'relative_velocity' => $approach->relativeVelocity,
                                'miss_distance' => $approach->missDistance,
                            ]
                        );
                    });
                });

            });

        } catch (Throwable $e) {
            Log::error('Failed to upsert NEO objects.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);


            throw $e;
        }
    }
}
