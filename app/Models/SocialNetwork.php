<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\SocialNetwork
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $image
 * @property string|null $url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|SocialNetwork newModelQuery()
 * @method static Builder|SocialNetwork newQuery()
 * @method static Builder|SocialNetwork query()
 * @method static Builder|SocialNetwork whereCreatedAt($value)
 * @method static Builder|SocialNetwork whereId($value)
 * @method static Builder|SocialNetwork whereImage($value)
 * @method static Builder|SocialNetwork whereName($value)
 * @method static Builder|SocialNetwork whereSlug($value)
 * @method static Builder|SocialNetwork whereUpdatedAt($value)
 * @method static Builder|SocialNetwork whereUrl($value)
 * @mixin Eloquent
 */
class SocialNetwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'url',
        'name',
        'slug',
    ];
}
