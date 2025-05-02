<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface NeoWriteRepositoryInterface
{
    public static function storeBatch(Collection $neos): void;
}
