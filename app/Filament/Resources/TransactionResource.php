<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionItemRelationManagerResource\RelationManagers\ItemsRelationManager;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $label = 'Transaction';
    protected static ?string $pluralLabel = 'Transactions';

    //  public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    // {
    //     return parent::getEloquentQuery()->where('user_id', auth()->id());
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('purchase_date')
                    ->required(),

                Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('User')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),

                Tables\Columns\TextColumn::make('purchase_date')
                    ->label('Tanggal Pembelian')
                    ->date(),

                Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date(),
            ])
            ->filters([
                // Tambahkan filter jika perlu
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
