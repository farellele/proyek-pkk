<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'developer_id',
        'title',
        'description',
        'price',
        'release_date',
        'genre_id',
        'platform_id',
        'status',
    ];

    protected $casts = [
        'release_date' => 'date',
        'last_updated' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class);
    }

}
