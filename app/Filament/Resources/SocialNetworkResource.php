<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\SocialNetworkResource\Pages;
use App\Models\SocialNetwork;
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

class SocialNetworkResource extends Resource
{
    protected static ?string $model = SocialNetwork::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        /** @var SocialNetwork $model */
        $model = static::getModel();

        return (string)$model::count();
    }

    public static function getNavigationGroup(): string
    {
        return __('navigation.settings');
    }

    public static function getPluralModelLabel(): string
    {
        return __('models.social_networks');
    }

    public static function getModelLabel(): string
    {
        return __('models.social_network');
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
                            ->unique(SocialNetwork::class, 'slug', ignoreRecord: true)
                            ->label(__('fields.slug')),
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
                            ->directory('images/social-networks')
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
                    ->after(function (SocialNetwork $socialNetwork) {
                        if ($socialNetwork->image) {
                            Storage::disk('public')->delete($socialNetwork->image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function (Collection $records) {
                            /** @var SocialNetwork $value */
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
            'index' => Pages\ListSocialNetworks::route('/'),
            'create' => Pages\CreateSocialNetwork::route('/create'),
            'edit' => Pages\EditSocialNetwork::route('/{record}/edit'),
        ];
    }

    /** @return Builder<SocialNetwork> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'slug'];
    }
}
