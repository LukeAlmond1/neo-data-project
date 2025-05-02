<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property int $id
 * @property int $total_neo_count
 * @property float $avg_estimated_diameter_min
 * @property float $avg_estimated_diameter_max
 * @property float $max_velocity
 * @property float $min_miss_distance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NeoObject> $neoObjects
 * @property-read int|null $neo_objects_count
 * @method static \Database\Factories\NeoDataAnalysisFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereAvgEstimatedDiameterMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereAvgEstimatedDiameterMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereMaxVelocity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereMinMissDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereTotalNeoCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|NeoDataAnalysis whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NeoDataAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_neo_count',
        'avg_estimated_diameter_min',
        'avg_estimated_diameter_max',
        'max_velocity',
        'min_miss_distance',
    ];

    protected $casts = [
        'total_neo_count' => 'integer',
        'avg_estimated_diameter_min' => 'float',
        'avg_estimated_diameter_max' => 'float',
        'max_velocity' => 'float',
        'min_miss_distance' => 'float',
    ];

    public function neoObjects() : BelongsToMany
    {
        return $this->belongsToMany(NeoObject::class)->withTimestamps();
    }
}
