<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\SocialNetwork;
use Illuminate\Support\Facades\Storage;

class SocialNetworkObserver
{
    public function updated(SocialNetwork $socialNetwork): void
    {
        if ($socialNetwork->image !== $socialNetwork->getOriginal('image')) {
            Storage::disk('public')->delete($socialNetwork->getOriginal('image'));
        }
    }
}
