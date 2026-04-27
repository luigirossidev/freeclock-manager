<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Riddles;
use App\Filament\Resources\RiddlesCategoryResource\Pages;
use App\Filament\Resources\RiddlesCategoryResource\RelationManagers;
use App\Models\RiddlesCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiddlesCategoryResource extends Resource
{
    protected static ?string $model = RiddlesCategory::class;

    protected static ?string $cluster = Riddles::class;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('riddles.category_plural');
    }
    public static function getModelLabel(): string
    {
        return __('riddles.category_singular');
    }
    public static function getPluralModelLabel(): string
    {
        return __('riddles.category_plural');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('riddles.category_singular'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('locale')
                    ->label('Lingua')
                    ->options(['it' => 'Italiano', 'en' => 'English'])
                    ->default('it')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('riddles.category_singular'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('riddles.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('riddles.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->label('Lingua')
                    ->options(['it' => 'Italiano', 'en' => 'English']),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRiddlesCategories::route('/'),
        ];
    }
}
