<?php

namespace Tests\Unit\Services;

use App\Enums\UnitsEnum;
use App\Services\UnitService;
use \Tests\TestCase;

class UnitServiceTest extends TestCase
{
    public function testConvertsKilometersToMeters(): void
    {
        $result = UnitService::convertToMetres(UnitsEnum::KILOMETERS, 12.34);
        $this->assertEquals(12340.0, $result);
    }
}
