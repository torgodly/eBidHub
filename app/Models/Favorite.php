<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'auction_id'];


    //auctions
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
