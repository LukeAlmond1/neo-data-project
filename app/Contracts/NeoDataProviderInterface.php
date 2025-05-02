<?php

namespace App\Contracts;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;


interface NeoDataProviderInterface
{
    public function fetchForDateRange(Carbon $startDate, Carbon $endDate): Collection;
}
