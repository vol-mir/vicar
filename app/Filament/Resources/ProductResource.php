<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\Widgets\ProductStats;
use App\Models\Product;
use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\BooleanConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): string
    {
        return __('navigation.shop');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.products');
    }

    public static function getModelLabel(): string
    {
        return __('models.product');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
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
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->label(__('fields.slug')),
                                Forms\Components\RichEditor::make('description')
                                    ->columnSpan('full')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('images/description-products')
                                    ->label(__('fields.description')),
                            ])
                            ->columns(),
                        Forms\Components\Section::make(__('fields.inventory'))
                            ->schema([
                                Forms\Components\TextInput::make('sku')
                                    ->maxLength(255)
                                    ->label(__('fields.sku')),
                            ])
                            ->columns(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make(__('fields.status'))
                            ->schema([
                                Forms\Components\Toggle::make('is_visible')
                                    ->label(__('fields.is_visible')),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label(__('fields.published_at')),
                            ])
                            ->columns(1),
                        Forms\Components\Section::make(__('fields.associations'))
                            ->schema([
                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label(__('fields.brand_name')),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    /**
     * @throws Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('mainImage.image')
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
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.brand_name')),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean()
                    ->label(__('fields.is_visible')),
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.sku')),
                Tables\Columns\TextColumn::make('published_at')
                    ->searchable()
                    ->sortable()
                    ->date('d.m.Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('fields.published_at')),
            ])
            ->filters([
                QueryBuilder::make()
                    ->constraints([
                        TextConstraint::make('name')
                            ->label(__('fields.name')),
                        TextConstraint::make('slug')
                            ->label(__('fields.slug')),
                        TextConstraint::make('sku')
                            ->label(__('fields.sku')),
                        TextConstraint::make('description')
                            ->label(__('fields.description')),
                        BooleanConstraint::make('is_visible')
                            ->label(__('fields.is_visible')),
                        DateConstraint::make('published_at')
                            ->label(__('fields.published_at')),
                    ])
                    ->constraintPickerColumns(),
            ], layout: Tables\Enums\FiltersLayout::AboveContentCollapsible)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading(__('models.empty_items'));
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductImagesRelationManager::class,
            RelationManagers\CategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    /** @return Builder<Product> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['brand']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug', 'description', 'sku', 'brand.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        /** @var Product $record */

        return [
            'Brand' => optional($record->brand)->name,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ProductStats::class,
        ];
    }
}
