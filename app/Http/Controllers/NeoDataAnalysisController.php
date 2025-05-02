<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\GetNeoDataAnalysisRequest;
use App\Http\Resources\NeoDataAnalysisResource;
use App\Models\NeoDataAnalysis;
use Illuminate\Http\JsonResponse;

class NeoDataAnalysisController extends Controller
{
    public function get(GetNeoDataAnalysisRequest $request): JsonResponse
    {
        $query = NeoDataAnalysis::query();

        if ($request->hasDateRange()) {
            $query->whereBetween('created_at', [
                $request->startDate(),
                $request->endDate(),
            ]);
        }

        $results = $query->latest('created_at')->paginate(10);

        return NeoDataAnalysisResource::collection($results)->response();
    }
}
