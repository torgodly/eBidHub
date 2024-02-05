<?php

namespace App\Models;

use App\Events\AuctionWinner;
use App\Events\BidPlaced;
use App\Events\MyEvent;
use App\Notifications\NotifyAuctionWinner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'minimum_bid',
        'winner_id',
        'buy_now',
        'winner_code',
        'approved',
        "buy_now_price"
    ];


    //casts
    protected $casts = [
        'info' => 'json',
    ];


    //attributes status
    public function getStatusAttribute()
    {
        if ($this->end < now() || $this->has_winner) {
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


    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    //winner bid is the highest bid before the auction ends
    public function getWinnerBidAttribute()
    {
        return $this->bids()->latest()->first();
    }


    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    //winner name
    public function getWinnerNameAttribute()
    {
        return $this->winner ? $this->winner->name : __("No winner In this auction");
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

    public function Activities()
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
        if (auth()->user()->balance < $amount + $this->end_price) {
            throw new \Exception(__("You do not have enough money to place this bid"));
        }

        //if  there is time left
        if ($this->status !== 'closed') {
            $this->bids()->create([
                'user_id' => auth()->id(),
                'amount' => $amount + $this->end_price,
            ]);
            event(new BidPlaced(__('A new bid has been placed')));
        } //if auction is closed
        else {
            throw new \Exception(__('This auction is closed'));
        }


    }

    //buyNow

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buyNow()
    {
        //check if user has enough money
        if (auth()->user()->balance < $this->buy_now_price) {
            throw new \Exception(__('You do not have enough money to buy this item'));
        }

        //if  there is time left
        if ($this->status !== 'closed') {
            $this->bids()->create([
                'user_id' => auth()->id(),
                'amount' => $this->buy_now_price,
            ]);

            //deduct money from user
            auth()->user()->update([
                'balance' => auth()->user()->balance - $this->buy_now_price,
            ]);
            //update winner id0
            $this->update([
                'winner_id' => auth()->id(),
            ]);
            event(new AuctionWinner(auth()->user()->id, $this->id));

        } //if auction is closed
        else {
            throw new \Exception(__('This auction is closed'));
        }
    }

    //place bid

    public function getHasEndedAttribute()
    {
        return $this->end < now();
    }


    //categorys
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    //haswinner
    public function getHaswinnerAttribute()
    {
        return $this->winner_id !== null;
    }

    //approved auction by admin
    public function approve()
    {
        $this->update([
            'approved' => true,
        ]);
    }

    //decline
    public function decline()
    {
        $this->update([
            'approved' => false,
        ]);
    }

    //checkwinner
    public function checkWinners()
    {
        // Get all the bids for this auction, ordered by amount in descending order
        $bids = $this->bids()->orderBy('amount', 'desc')->get();


        // Get the highest bid
        $highestBid = $bids->first();

        if ($highestBid) {
            // Set the winner and generate a random winner code
            $this->winner_id = $highestBid->user_id ?? 0;
            $this->winner_code = $highestBid ? Str::random(10) : "Auction has ended without a winner";
            $this->save();

            // Withdraw the winning amount from the winner's account
            $highestBid->user->withdraw($highestBid->amount);

            // Notify the winner through an event
            event(new AuctionWinner($highestBid->user_id, $this->id));

            // Notify the winner via email
            $highestBid->user->notify(new NotifyAuctionWinner($this));
        } else {
            $this->update([
                'winner_code' => "Auction has ended without a winner",
                'winner_id' => 0,
            ]);
        }

    }

    //favoritedBy

    public function isFavorited()
    {
        return $this->favoritedBy()->where('user_id', auth()->id())->exists();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

}
