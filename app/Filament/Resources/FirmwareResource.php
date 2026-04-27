<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FirmwareResource\Pages;
use App\Filament\Resources\FirmwareResource\RelationManagers;
use App\Models\Firmware;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FirmwareResource extends Resource
{
    protected static ?string $model = Firmware::class;

    protected static ?string $navigationIcon = 'heroicon-c-cube';

    public static function getNavigationLabel(): string
    {
        return __('firmware.archive');
    }
    public static function getModelLabel(): string
    {
        return __('firmware.single');
    }
    public static function getPluralModelLabel(): string
    {
        return __('firmware.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('firmware.name'))
                    ->required()
                    ->maxLength(255)
                    ->translatableTabs(),
                Forms\Components\TextInput::make('device_code')
                    ->label(__('firmware.device_code'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('version')
                    ->label(__('firmware.version'))
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('bin_file')
                    ->label(__('firmware.bin_file'))
                    ->required()
                    ->downloadable()
                ,
                Forms\Components\Toggle::make('is_active')
                    ->label(__('firmware.is_active'))
                    ->required(),
                Forms\Components\RichEditor::make('notes')
                    ->label(__('firmware.notes'))
                    ->disableToolbarButtons([
                        'attachFiles',
                        'codeBlock',
                        'link',
                        'h2', 'h3',
                        'undo', 'redo',
                    ])
                    ->translatableTabs()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('firmware.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('device_code')
                    ->label(__('firmware.device_code'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('version')
                    ->label(__('firmware.version'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('firmware.is_active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('firmware.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('firmware.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFirmware::route('/'),
            'create' => Pages\CreateFirmware::route('/create'),
            'edit' => Pages\EditFirmware::route('/{record}/edit'),
        ];
    }
}
