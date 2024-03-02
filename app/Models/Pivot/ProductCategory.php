<?php

declare(strict_types=1);

namespace App\Models\Pivot;

use App\Models\Category;
use App\Models\Product;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Carbon;

/**
 * App\Models\Pivot\ProductCategory
 *
 * @property int $id
 * @property bool $is_main
 * @property int $category_id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $category
 * @property-read Product|null $product
 * @method static Builder|ProductCategory newModelQuery()
 * @method static Builder|ProductCategory newQuery()
 * @method static Builder|ProductCategory query()
 * @method static Builder|ProductCategory whereCategoryId($value)
 * @method static Builder|ProductCategory whereCreatedAt($value)
 * @method static Builder|ProductCategory whereId($value)
 * @method static Builder|ProductCategory whereIsMain($value)
 * @method static Builder|ProductCategory whereProductId($value)
 * @method static Builder|ProductCategory whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductCategory extends Pivot
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'is_main',
        'category_id',
        'product_id',
    ];

    protected $casts = [
        'is_main' => 'bool',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
