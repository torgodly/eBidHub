<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //has many relationship with Auction
    public function auctions()
    {
        return $this->belongsToMany(Auction::class);
    }

    //use count method to get the number of auctions in a category Attribute
    public function getAuctionsCountAttribute()
    {
        return $this->auctions->where('approved', true)->where('end', '>', now()->subWeek())->count();
    }
}
