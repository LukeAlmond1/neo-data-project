<?php

declare(strict_types=1);

namespace App\Enums;

enum NasaNeoDataEndpointsEnum : string
{
    case FEED = 'feed';

    public function uri(): string
    {
        return "/" . $this->value;
    }
}
