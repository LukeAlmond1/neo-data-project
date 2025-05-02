<?php

namespace App\Contracts;

interface NeoApiDataInterface
{

    public static function createFromApi (array $data): self;
}
