<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Auction extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    //fillable
    protected $fillable = [
        'title',
        'info',
        'description',
        'price',
        'start',
        'end',
        'user_id'
    ];


    //casts
    protected $casts = [
        'info' => 'json',
    ];


    //attributes status
    public function getStatusAttribute()
    {
        if ($this->start > now()) {
            return 'upcoming';
        }

        if ($this->end < now()) {
            return 'closed';
        }

        return 'active';
    }

    //bid
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    //bids count attribute
    public function getBidsCountAttribute()
    {
        return $this->bids()->count();
    }
}
