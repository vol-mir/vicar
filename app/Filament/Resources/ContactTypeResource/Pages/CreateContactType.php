<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactTypeResource\Pages;

use App\Filament\Resources\ContactTypeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContactType extends CreateRecord
{
    protected static string $resource = ContactTypeResource::class;
}
