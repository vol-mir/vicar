<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Shop;
use Illuminate\Support\Facades\Storage;

class ShopObserver
{
    public function deleting(Shop $shop): void
    {
        foreach ($shop->shopImages as $shopImage) {
            if (!empty($shopImage->image)) {
                Storage::disk('public')->delete($shopImage->image);
            }
        }
    }
}
