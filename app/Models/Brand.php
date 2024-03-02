<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property string|null $description
 * @property string|null $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static Builder|Brand newModelQuery()
 * @method static Builder|Brand newQuery()
 * @method static Builder|Brand query()
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereDescription($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereImage($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereSlug($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @method static Builder|Brand whereUrl($value)
 * @mixin Eloquent
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'description',
        'url',
        'name',
        'slug',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
