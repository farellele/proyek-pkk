<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'purchase_date',
        'total_price',
    ];

    protected $casts = [
        'purchase_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function libraryItems()
    {
        return $this->hasMany(Library::class);
    }

}
