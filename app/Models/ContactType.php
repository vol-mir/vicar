<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\ContactType
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, ContactType> $contacts
 * @property-read int|null $contacts_count
 * @method static Builder|ContactType newModelQuery()
 * @method static Builder|ContactType newQuery()
 * @method static Builder|ContactType query()
 * @method static Builder|ContactType whereCreatedAt($value)
 * @method static Builder|ContactType whereId($value)
 * @method static Builder|ContactType whereName($value)
 * @method static Builder|ContactType whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ContactType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(ContactType::class);
    }
}
