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
        'about', // 'about' is the auction's 'short description
        'description',
        'price',
        'end',
        'user_id',
        'minimum_bid'
    ];


    //casts
    protected $casts = [
        'info' => 'json',
    ];


    //attributes status
    public function getStatusAttribute()
    {
        if ($this->end < now()) {
            return 'closed';
        }
        //ending soon
        if ($this->end < now()->addHours(3)) {
            return 'ending soon';
        }

        return 'active';
    }

    //bid

    public function getBidsCountAttribute()
    {
        return $this->bids()->count();
    }

    //bids count attribute

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    //winner bid is the highest bid before the auction ends
    public function getWinnerBidAttribute()
    {
        return $this->bids()->latest()->first();
    }

    //winner is the user who made the highest bid before the auction ends
    public function getWinnerAttribute()
    {
        return $this->winnerBid->user;
    }

    //user

    public function getEndPriceAttribute()
    {
        if ($this->winnerBid) {
            return $this->winnerBid->amount;
        }

        return $this->price;
    }

    //auction price is the highest bid  if there is no bids then it is the starting price

    public function getActivitiesAttribute()
    {
        $comments = $this->comments()->get();
        $bids = $this->bids()->get();

        $activities = $comments->concat($bids)->sortByDesc('created_at');

        return $activities;
    }

    //current price is the highest bid  if there is no bids then it is the starting price

    //commants

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //get bids and comments merget by created at

    public function placeBid($amount)
    {
        //check if user has enough money
        if (auth()->user()->balance < $amount) {
            throw new \Exception('You do not have enough money to place this bid');
        }
        $this->bids()->create([
            'user_id' => auth()->id(),
            'amount' => $amount + $this->end_price,
        ]);
        //deduct money from user
        auth()->user()->update([
            'balance' => auth()->user()->balance - $amount,
        ]);

    }


    //place bid

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
