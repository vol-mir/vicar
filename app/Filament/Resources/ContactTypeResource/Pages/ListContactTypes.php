<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactTypeResource\Pages;

use App\Filament\Resources\ContactTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactTypes extends ListRecords
{
    protected static string $resource = ContactTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
