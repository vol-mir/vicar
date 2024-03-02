<?php

declare(strict_types=1);

namespace App\Filament\Resources\ShopResource\RelationManagers;

use Exception;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('models.contacts');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label(__('fields.name')),
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255)
                    ->label(__('fields.value')),
                Forms\Components\Select::make('contact_type_id')
                    ->relationship('contactType', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label(__('fields.name')),
                    ])
                    ->label(__('fields.contact_type')),
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
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.name')),
                Tables\Columns\TextColumn::make('value')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.value')),
                Tables\Columns\TextColumn::make('contactType.name')
                    ->searchable()
                    ->sortable()
                    ->label(__('fields.contact_type')),
                Tables\Columns\TextColumn::make('shop.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label(__('fields.shop')),
            ])
            ->filters([
                SelectFilter::make('contactType')
                    ->relationship('contactType', 'name')
                    ->searchable()
                    ->preload()
                    ->label(__('fields.contact_type')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
            ->modelLabel(__('models.contact'))
            ->emptyStateHeading(__('models.empty_items'));
    }
}
