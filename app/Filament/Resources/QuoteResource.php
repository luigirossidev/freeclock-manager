<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Quotes;
use App\Filament\Resources\QuoteResource\Pages;
use App\Filament\Resources\QuoteResource\RelationManagers;
use App\Models\Quote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuoteResource extends Resource
{
    protected static ?string $model = Quote::class;

    protected static ?string $cluster = Quotes::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('quotes.archive');
    }
    public static function getModelLabel(): string
    {
        return __('quotes.single');
    }
    public static function getPluralModelLabel(): string
    {
        return __('quotes.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('quote')
                    ->label(__('quotes.single'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_id')
                    ->label(__('quotes.form_category'))
                    ->required()
                    ->native(false)
                    ->preload()
                    ->relationship('category', 'name')
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->autofocus()
                            ->required()
                            ->label(__('quotes.category_singular')),
                        Forms\Components\Select::make('locale')
                            ->label('Lingua')
                            ->options(['it' => 'Italiano', 'en' => 'English'])
                            ->default('it')
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('quote')
                    ->label(__('quotes.single'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('quotes.form_category'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.locale')
                    ->label('Lingua')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('quotes.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('quotes.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label(__('quotes.form_categories'))
                    ->multiple()
                    ->preload()
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('locale')
                    ->label('Lingua')
                    ->options(['it' => 'Italiano', 'en' => 'English'])
                    ->query(fn (Builder $query, array $data) =>
                        $data['value'] ? $query->whereHas('category', fn ($q) => $q->where('locale', $data['value'])) : $query
                    ),
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
            'index' => Pages\ManageQuotes::route('/'),
        ];
    }
}
