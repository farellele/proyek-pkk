<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_id',
        'transaction_id',
        'status',
        'added_at',
    ];

    protected $casts = [
        'added_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
