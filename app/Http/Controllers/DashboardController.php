<?php

namespace App\Http\Controllers;

use App\Http\Resources\NeoDataAnalysisResource;
use App\Models\NeoDataAnalysis;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $analysis = NeoDataAnalysisResource::collection(
            NeoDataAnalysis::latest()->take(10)->get()
        );

        return Inertia::render('dashboard', [
            'analysis' => [
                'data' => $analysis,
            ],
        ]);
    }
}
