<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageObserver
{
    public function updated(ProductImage $productImage): void
    {
        if ($productImage->image !== $productImage->getOriginal('image')) {
            Storage::disk('public')->delete($productImage->getOriginal('image'));
        }
    }
}
