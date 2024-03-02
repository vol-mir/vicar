<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\ProductImage;
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

class ProductImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'productImages';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('models.product_images');
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
                    ->directory('images/product-images')
                    ->columnSpan('full')
                    ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): Stringable => str(Str::uuid() . '.' . $file->extension()))
                    ->label(__('fields.image')),
                Forms\Components\Toggle::make('is_main')
                    ->label(__('fields.is_main'))
                    ->default(true),
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
                Tables\Columns\IconColumn::make('is_main')
                    ->boolean()
                    ->label(__('fields.is_main')),
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
                    ->after(function (ProductImage $record) {
                        if ($record->image) {
                            Storage::disk('public')->delete($record->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (Collection $records) {
                            /** @var ProductImage $value */
                            foreach($records as $value) {
                                if ($value->image) {
                                    Storage::disk('public')->delete($value->image);
                                }
                            }
                        }),
                ]),
            ])
            ->modelLabel(__('models.product_image'))
            ->emptyStateHeading(__('models.empty_items'));
    }
}
