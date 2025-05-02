<?php

namespace App\Services;

use App\Enums\UnitsEnum;

class UnitService
{

    public static function convertToMetres(UnitsEnum $sourceUnit, float $value) : float
    {
        return match ($sourceUnit) {
            UnitsEnum::KILOMETERS => $value * 1000,
            default => throw new \InvalidArgumentException("Unsupported unit: {$sourceUnit->value}")
        };
    }
}
