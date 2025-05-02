<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 *
 * @property int $id
 * @property string $reference_id
 * @property string $name
 * @property float $estimated_diameter_min
 * @property float $estimated_diameter_max
 * @property bool $is_hazardous
 * @property float $absolute_magnitude
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NeoDataAnalysis> $analyses
 * @property-read int|null $analyses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CloseApproachData> $closeApproaches
 * @property-read int|null $close_approaches_count
 * @method static \Database\Factories\NeoObjectFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereAbsoluteMagnitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereEstimatedDiameterMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereEstimatedDiameterMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereIsHazardous($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoObject whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NeoObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'name',
        'absolute_magnitude',
        'estimated_diameter_min',
        'estimated_diameter_max',
        'is_hazardous',
    ];

    protected $casts = [
        'is_hazardous' => 'boolean',
    ];

    public function closeApproaches(): HasMany
    {
        return $this->hasMany(CloseApproachData::class);
    }
}
