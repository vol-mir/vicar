<?php

declare(strict_types=1);

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use App\Models\Brand;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    public function getTitle(): string | Htmlable
    {
        /** @var Brand $record */
        $record = $this->getRecord();

        return $record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function (Brand $record) {
                    if ($record->image) {
                        Storage::disk('public')->delete($record->image);
                    }
                }),
        ];
    }
}
