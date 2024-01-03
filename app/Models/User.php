<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Octopy\Impersonate\Concerns\HasImpersonation;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasImpersonation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'type'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * @return string
     */
    public function getImpersonateDisplayText(): string
    {
        return $this->name;
    }

    /**
     * This following is useful for performing user searches through the interface,
     * You can use fields in relations freely using dot notation,
     *
     * example: posts.title, department.name.
     */
    public function getImpersonateSearchField(): array
    {
        return [
            'name',
        ];
    }


    //auctions

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    //bids
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    //comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    //change type to seller
    public function becomeSeller()
    {
        $this->type = 'seller';
        $this->save();
    }


    //withdraw
    public function withdraw($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }





    public function wonAuctions()
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }
}
