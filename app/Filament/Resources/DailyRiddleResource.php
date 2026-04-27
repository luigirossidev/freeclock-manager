<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Riddles;
use App\Filament\Resources\DailyRiddleResource\Pages;
use App\Filament\Resources\DailyRiddleResource\RelationManagers;
use App\Models\DailyRiddle;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class DailyRiddleResource extends Resource
{
    protected static ?string $model = DailyRiddle::class;

    protected static ?string $cluster = Riddles::class;

    protected static ?string $navigationIcon = 'heroicon-c-calendar-days';
    protected static ?int $navigationSort = 3;

    public static function getNavigationLabel(): string
    {
        return __('riddles.daily_plural');
    }
    public static function getModelLabel(): string
    {
        return __('riddles.daily_singular');
    }
    public static function getPluralModelLabel(): string
    {
        return __('riddles.daily_plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('day')
                    ->label(__('riddles.form_day'))
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Select::make('locale')
                    ->label('Lingua')
                    ->options(['it' => 'Italiano', 'en' => 'English'])
                    ->default('it')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Select::make('riddle_id')
                    ->label(__('riddles.single'))
                    ->native(false)
                    ->required()
                    ->searchable()
                    ->relationship('riddle', 'riddle')
                    ->columnSpan(2),
            ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('day')
                    ->label(__('riddles.form_day'))
                    ->date("l d/m/Y")
                    ->sortable(),
                Tables\Columns\TextColumn::make('locale')
                    ->label('Lingua')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('riddle.riddle')
                    ->label(__('riddles.single'))
                    ->searchable(),
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
                DateRangeFilter::make('day')
                    ->label(__('riddles.form_day'))
                    ->withIndicator(),
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
            'index' => Pages\ManageDailyRiddles::route('/'),
        ];
    }
}
