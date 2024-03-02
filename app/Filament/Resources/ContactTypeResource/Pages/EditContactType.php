<?php

declare(strict_types=1);

namespace App\Filament\Resources\ContactTypeResource\Pages;

use App\Filament\Resources\ContactTypeResource;
use App\Models\ContactType;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditContactType extends EditRecord
{
    protected static string $resource = ContactTypeResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var ContactType $record */
        $record = $this->getRecord();

        return $record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
