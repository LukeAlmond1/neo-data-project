<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 *
 * @property int $id
 * @property int $neo_object_id
 * @property \Illuminate\Support\Carbon $close_approach_date_full
 * @property float $relative_velocity
 * @property float $miss_distance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\NeoObject $neoObject
 * @method static \Database\Factories\CloseApproachDataFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereCloseApproachDateFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereMissDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereNeoObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereRelativeVelocity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CloseApproachData whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CloseApproachData extends Model
{
    use HasFactory;

    protected $fillable = [
        'neo_object_id',
        'close_approach_date_full',
        'relative_velocity',
        'miss_distance',
    ];

    protected $casts = [
        'close_approach_date_full' => 'datetime',
        'relative_velocity' => 'float',
        'miss_distance' => 'float',
    ];
}
