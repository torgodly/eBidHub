<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Octopy\Impersonate\Concerns\HasImpersonation;

class User extends Authenticatable implements HasAvatar, FilamentUser, MustVerifyEmail
{


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
        'type',
        'phone_number',
        'avatar_url',
        'active'
    ];
    // ...
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    use HasApiTokens, HasFactory, Notifiable;
    use HasImpersonation , TwoFactorAuthenticatable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        if (Filament::getCurrentPanel()->getId() === 'admin') {
            return $this->type == 'admin';
        }

        if (Filament::getCurrentPanel()->getId() === 'seller') {
            return $this->type == 'admin' || $this->type == 'seller';
        }

        return false;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

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

    //is seller attribute
    public function getIsSellerAttribute()
    {
        return $this->type == 'seller';
    }

    //is admin attribute
    public function getIsAdminAttribute()
    {
        return $this->type == 'admin';
    }

    //Favorite
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    //favorit auctions
    public function favoriteAuctions()
    {
        return $this->belongsToMany(Auction::class, 'favorites', 'user_id', 'auction_id');
    }


    //check if user has any bids or balance  or auctions or any other relation
    public function hasAnyRelation()
    {
        return $this->bids->count() > 0 || $this->balance > 0 || $this->auctions->count() > 0 || $this->wonAuctions->count() > 0;
    }

}
