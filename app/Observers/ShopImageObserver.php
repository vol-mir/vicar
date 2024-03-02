<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ShopImage;
use Illuminate\Support\Facades\Storage;

class ShopImageObserver
{
    public function updated(ShopImage $shopImage): void
    {
        if ($shopImage->image !== $shopImage->getOriginal('image')) {
            Storage::disk('public')->delete($shopImage->getOriginal('image'));
        }
    }
}
