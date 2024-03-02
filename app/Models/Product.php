<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Pivot\ProductCategory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string|null $sku
 * @property string|null $description
 * @property bool $is_visible
 * @property string|null $published_at
 * @property int|null $brand_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Brand|null $brand
 * @property-read Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\Category|null $mainCategory
 * @property-read \App\Models\ProductImage|null $mainImage
 * @property-read Collection<int, \App\Models\ProductImage> $productImages
 * @property-read int|null $product_images_count
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereBrandId($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereIsVisible($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePublishedAt($value)
 * @method static Builder|Product whereSku($value)
 * @method static Builder|Product whereSlug($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'is_visible',
        'published_at',
        'seo_title',
        'seo_description',
        'brand_id',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this
            ->belongsToMany(Category::class, 'product_category', 'product_id', 'category_id')
            ->using(ProductCategory::class)
            ->withPivot(['is_main'])
            ->withTimestamps();
    }

    public function mainCategory(): HasOneThrough
    {
        return $this
            ->hasOneThrough(
                Category::class,
                ProductCategory::class,
                'category_id',
                'id',
                'id',
                'product_id'
            )
            ->where('product_category.is_main', true);
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true);
    }
}
