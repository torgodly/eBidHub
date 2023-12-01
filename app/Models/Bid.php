<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'user_id',
        'amount',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    //user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
