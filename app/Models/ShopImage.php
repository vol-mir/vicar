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
 * App\Models\ShopImage
 *
 * @property int $id
 * @property string|null $image
 * @property string $name
 * @property string|null $description
 * @property int|null $shop_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Shop|null $shop
 * @method static Builder|ShopImage newModelQuery()
 * @method static Builder|ShopImage newQuery()
 * @method static Builder|ShopImage query()
 * @method static Builder|ShopImage whereCreatedAt($value)
 * @method static Builder|ShopImage whereDescription($value)
 * @method static Builder|ShopImage whereId($value)
 * @method static Builder|ShopImage whereImage($value)
 * @method static Builder|ShopImage whereName($value)
 * @method static Builder|ShopImage whereShopId($value)
 * @method static Builder|ShopImage whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ShopImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'shop_id',
        'image',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
