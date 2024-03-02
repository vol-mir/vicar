<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ContactTypeResource\Pages;
use App\Models\ContactType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactTypeResource extends Resource
{
    protected static ?string $model = ContactType::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 0;

    public static function getNavigationGroup(): string
    {
        return __('navigation.directories');
    }

    public static function getPluralLabel(): string
    {
        return __('models.contact_types');
    }

    public static function getModelLabel(): string
    {
        return __('models.contact_type');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->maxLength(255)
                    ->columnSpan('full')
                    ->label(__('fields.name')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.name')),
            ])
            ->filters([
            ])
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactTypes::route('/'),
            'create' => Pages\CreateContactType::route('/create'),
            'edit' => Pages\EditContactType::route('/{record}/edit'),
        ];
    }

    /** @return Builder<ContactType> */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
