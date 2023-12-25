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
}
