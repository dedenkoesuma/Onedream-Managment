<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Judul Portofolio')
                    ->required()
                    ->minLength(3)
                    ->maxLength(255),
                Select::make('category')
                    ->label('Pilih Kategori')
                    ->options([
                        'Foto' => 'Fotografi',
                        'Desain' => 'Desain Grafis',
                        'Video' => 'Videografi',
                    ])
                    ->required(),

                FileUpload::make('image')
                    ->label('Masukan Lampiran/image')
                    ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul Portofolio')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Jenis Kategori')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image')
                    ->label('Portofolio')
                    ->size(100)
                    ->square()
                    ->sortable()
                    ->searchable()
                    ->visibility('private'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolio::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }
    public static function getPluralLabel(): string
    {
        return 'Portfolio';
    }
}
