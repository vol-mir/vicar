<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\Shop;
use App\Models\ShopImage;
use App\Models\SocialNetwork;
use App\Observers\BrandObserver;
use App\Observers\ProductImageObserver;
use App\Observers\ShopImageObserver;
use App\Observers\ShopObserver;
use App\Observers\SocialNetworkObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Brand::observe(BrandObserver::class);
        ShopImage::observe(ShopImageObserver::class);
        Shop::observe(ShopObserver::class);
        SocialNetwork::observe(SocialNetworkObserver::class);
        ProductImage::observe(ProductImageObserver::class);
    }
}
