<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;

class FinanceResource extends Resource
{
    protected static ?string $model = Finance::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                    ->label('Tanggal Keuangan')
                    ->required(),

                Select::make('finance_type')
                    ->options([
                        'masuk' => 'Pemasukan',
                        'keluar' => 'Pengeluaran',
                    ])
                    ->label('Jenis Keuangan')
                    ->required()
                    ->reactive(),
                TextInput::make('masuk')
                    ->label('Jumlah Pemasukan')
                    ->type('text')
                    ->extraAttributes(['class' => 'input-mata-uang'])
                    ->hidden(fn ($get) => $get('finance_type') !== 'masuk'),

                TextInput::make('keluar')
                    ->label('Jumlah Pengeluaran')
                    ->type('text')
                    ->extraAttributes(['class' => 'input-mata-uang'])
                    ->hidden(fn ($get) => $get('finance_type') !== 'keluar'),
                Textarea::make('description')
                    ->label('Deskripsi Keuangan')
                    ->minLength(3)
                    ->maxLength(255)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('masuk')
                    ->label('Pemasukan')
                    ->formatStateUsing(fn ($state) => "Rp " . number_format($state, 0, ',', '.')),

                TextColumn::make('keluar')
                    ->label('Pengeluaran')
                    ->formatStateUsing(fn ($state) => "Rp " . number_format($state, 0, ',', '.')),
                TextColumn::make('total')
                    ->label('Total Keuangan')
                    ->formatStateUsing(fn ($state) => "Rp " . number_format($state, 0, ',', '.')),

                TextColumn::make('description')
                    ->label('Deskripsi Keuangan')
                    ->searchable()
                    ->limit(100),
            ])
            ->filters([
                //
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
            'index' => Pages\ListFinances::route('/'),
            'create' => Pages\CreateFinance::route('/create'),
            'edit' => Pages\EditFinance::route('/{record}/edit'),
        ];
    }

    public static function getPluralLabel(): string
    {
        return 'Keuangan';
    }
}
