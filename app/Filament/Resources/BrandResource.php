<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        /** @var Brand $model */
        $model = static::getModel();

        return (string)$model::count();
    }

    public static function getNavigationGroup(): string
    {
        return __('navigation.shop');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.brands');
    }

    public static function getModelLabel(): string
    {
        return __('models.brand');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(onBlur: true)
                            ->maxLength(255)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                            ->label(__('fields.name')),
                        Forms\Components\TextInput::make('slug')
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Brand::class, 'slug', ignoreRecord: true)
                            ->label(__('fields.slug')),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->label(__('fields.description')),
                        Forms\Components\TextInput::make('url')
                            ->url()
                            ->maxLength(255)
                            ->columnSpan('full')
                            ->label(__('fields.url')),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('fields.image'))
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('images/brands')
                            ->columnSpan('full')
                            ->getUploadedFileNameForStorageUsing(fn(TemporaryUploadedFile $file): Stringable => str(Str::uuid() . '.' . $file->extension()))
                            ->label(__('fields.image')),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->height(50)
                    ->label(__('fields.image')),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.name')),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('fields.slug')),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->after(function (Brand $brand) {
                        if ($brand->image) {
                            Storage::disk('public')->delete($brand->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (Collection $records) {
                            /** @var Brand $value */
                            foreach($records as $value) {
                                if ($value->image) {
                                    Storage::disk('public')->delete($value->image);
                                }
                            }
                        })
                ]),
            ])
            ->emptyStateHeading(__('models.empty_items'));
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    /** @return Builder<Brand> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }
}
