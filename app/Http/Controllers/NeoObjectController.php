<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\NeoObjectResource;
use App\Models\NeoObject;

class NeoObjectController extends Controller
{

    public function show(NeoObject $neoObject): NeoObjectResource
    {
        return new NeoObjectResource($neoObject->load('closeApproaches'));
    }

}
