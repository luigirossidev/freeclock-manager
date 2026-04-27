<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function getNavigationLabel(): string
    {
        return __('news.archive');
    }

    public static function getModelLabel(): string
    {
        return __('news.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('news.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('news.title'))
                    ->required()
                    ->maxLength(255)
                    ->translatableTabs(),
                Forms\Components\DateTimePicker::make('published_at')
                    ->label(__('news.published_at'))
                    ->helperText('Lascia vuoto per salvare come bozza'),
                Forms\Components\FileUpload::make('image')
                    ->label(__('news.image'))
                    ->image()
                    ->imageEditor()
                    ->imageResizeMode('cover')
                    ->imageResizeTargetWidth(1200)
                    ->imageResizeTargetHeight(800)
                    ->imageResizeUpscale(false)
                    ->directory('news')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('content')
                    ->label(__('news.content'))
                    ->required()
                    ->disableToolbarButtons([
                        'attachFiles',
                        //'codeBlock',
                    ])
                    ->translatableTabs()
                    ->columnSpanFull(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('news.image'))
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('news.title'))
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('news.published_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder(__('news.draft')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('news.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('news.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('published')
                    ->label(__('news.published'))
                    ->query(fn ($query) => $query->published()),
                Tables\Filters\Filter::make('draft')
                    ->label(__('news.draft'))
                    ->query(fn ($query) => $query->whereNull('published_at')),
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
