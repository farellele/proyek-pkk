<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionItemResource\Pages;
use App\Filament\Resources\TransactionItemResource\RelationManagers;
use App\Models\TransactionItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionItemResource extends Resource
{
    protected static ?string $model = TransactionItem::class;

    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                 Forms\Components\Select::make('transaction_id')
                    ->relationship('transaction', 'id')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('game_id')
                    ->relationship('game', 'title')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('price_at_purchase')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                Tables\Columns\TextColumn::make('transaction.id')->label('Transaksi'),
                Tables\Columns\TextColumn::make('game.title')->label('Game'),
                Tables\Columns\TextColumn::make('price_at_purchase')->money('IDR'),
                Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->date(),
            ])
            ->filters([])
             ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTransactionItems::route('/'),
            'create' => Pages\CreateTransactionItem::route('/create'),
            'view' => Pages\ViewTransactionItem::route('/{record}'),
            'edit' => Pages\EditTransactionItem::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
         return false;
    }

}
