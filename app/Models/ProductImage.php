<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\ProductImage
 *
 * @property int $id
 * @property string|null $image
 * @property bool $is_main
 * @property string $name
 * @property string|null $description
 * @property int|null $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Product|null $product
 * @method static Builder|ProductImage newModelQuery()
 * @method static Builder|ProductImage newQuery()
 * @method static Builder|ProductImage query()
 * @method static Builder|ProductImage whereCreatedAt($value)
 * @method static Builder|ProductImage whereDescription($value)
 * @method static Builder|ProductImage whereId($value)
 * @method static Builder|ProductImage whereImage($value)
 * @method static Builder|ProductImage whereIsMain($value)
 * @method static Builder|ProductImage whereName($value)
 * @method static Builder|ProductImage whereProductId($value)
 * @method static Builder|ProductImage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_main',
        'description',
        'product_id',
        'image',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
