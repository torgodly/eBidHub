<?php

namespace App\Http\Controllers;

use App\Models\Auction;

class FavoriteController extends Controller
{
//    index
    public function index()
    {
        $auctions =\Auth::user()->favoriteAuctions;
        return view('favorites.index',
        ['auctions' => $auctions]
        );
    }
}
