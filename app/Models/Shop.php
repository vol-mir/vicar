<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Shop
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $registration_number
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ShopImage> $shopImages
 * @property-read int|null $shop_images_count
 * @method static Builder|Shop newModelQuery()
 * @method static Builder|Shop newQuery()
 * @method static Builder|Shop query()
 * @method static Builder|Shop whereCreatedAt($value)
 * @method static Builder|Shop whereDescription($value)
 * @method static Builder|Shop whereId($value)
 * @method static Builder|Shop whereName($value)
 * @method static Builder|Shop whereRegistrationNumber($value)
 * @method static Builder|Shop whereSlug($value)
 * @method static Builder|Shop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'registration_number',
        'description',
        'slug',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function shopImages(): HasMany
    {
        return $this->hasMany(ShopImage::class);
    }
}
