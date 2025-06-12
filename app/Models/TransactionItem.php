<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'game_id',
        'price_at_purchase',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
