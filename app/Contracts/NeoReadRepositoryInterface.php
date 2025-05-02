<?php

namespace App\Contracts;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

interface NeoReadRepositoryInterface
{

    public function getDataForDateRange(Carbon $startDate, Carbon $endDate): Collection;

}
