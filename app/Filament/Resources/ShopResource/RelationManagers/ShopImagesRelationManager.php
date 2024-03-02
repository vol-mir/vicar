<?php

declare(strict_types=1);

namespace App\Filament\Resources\ShopResource\RelationManagers;

use App\Models\ShopImage;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ShopImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'shopImages';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('models.shop_images');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('fields.name')),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('images/shop-images')
                    ->columnSpan('full')
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): Stringable => str(Str::uuid() . '.' . $file->extension()))
                    ->label(__('fields.image')),
                Forms\Components\Textarea::make('description')
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->label(__('fields.description')),
            ]);
    }

    /**
     * @throws Exception
     */
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->height(50)
                    ->label(__('fields.image')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.name')),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function (ShopImage $record) {
                        if ($record->image) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (Collection $records) {
                            /** @var ShopImage $value */
                            foreach($records as $value) {
                                if ($value->image) {
                                    Storage::disk('public')->delete($value->image);
                                }
                            }
                        }),
                ]),
            ])
            ->modelLabel(__('models.shop_image'))
            ->emptyStateHeading(__('models.empty_items'));
    }
}
