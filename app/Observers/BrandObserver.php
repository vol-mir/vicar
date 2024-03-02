<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandObserver
{
    public function updated(Brand $brand): void
    {
        if ($brand->image !== $brand->getOriginal('image')) {
            Storage::disk('public')->delete($brand->getOriginal('image'));
        }
    }
}
