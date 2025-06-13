<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryResource\Pages;
use App\Models\Library;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LibraryResource extends Resource
{
    protected static ?string $model = Library::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'User Data';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('game_id')
                ->relationship('game', 'title')
                ->searchable()
                ->required(),

            Forms\Components\Select::make('transaction_id')
                ->relationship('transaction', 'id')
                ->searchable()
                ->label('Source Transaction')
                ->nullable(),

            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Active',
                    'revoked' => 'Revoked',
                    'expired' => 'Expired',
                    'pending' => 'Pending',
                ])
                ->required()
                ->default('active'),

            Forms\Components\DateTimePicker::make('added_at')
                ->label('Added At')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->searchable(),

            Tables\Columns\TextColumn::make('game.title')
                ->label('Game')
                ->searchable(),

            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'revoked' => 'danger',
                    'expired' => 'gray',
                    'pending' => 'warning',
                }),

            Tables\Columns\TextColumn::make('added_at')
                ->label('Added At')
                ->dateTime(),

            Tables\Columns\TextColumn::make('transaction.id')
                ->label('Transaction ID')
                ->searchable()
                ->sortable()
                ->toggleable(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraries::route('/'),
            'create' => Pages\CreateLibrary::route('/create'),
            'edit' => Pages\EditLibrary::route('/{record}/edit'),
        ];
    }
}
