<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Resources\TransactionItemRelationManagerResource\RelationManagers\ItemsRelationManager;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }
}
