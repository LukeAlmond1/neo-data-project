<?php

namespace App\Providers;

use App\Clients\NasaNeoClient;
use App\Collections\NasaNeoDataAnalysisCollection;
use App\Contracts\NeoDataAnalysisCollectionInterface;
use App\Contracts\NeoReadRepositoryInterface;
use App\Contracts\NeoWriteRepositoryInterface;
use App\Repositories\NasaNeoReadRepository;
use App\Repositories\NasaNeoWriteRepository;
use Illuminate\Support\ServiceProvider;

class NeoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NasaNeoClient::class, fn () => new NasaNeoClient());

        $this->app->bind(NeoWriteRepositoryInterface::class, NasaNeoWriteRepository::class);
        $this->app->bind(NeoReadRepositoryInterface::class, NasaNeoReadRepository::class);
        $this->app->bind(NeoDataAnalysisCollectionInterface::class, NasaNeoDataAnalysisCollection::class);
    }

    public function boot(): void
    {
        //
    }
}
