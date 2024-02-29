<?php

namespace App\Http\Controllers;

use App\Filters\AuctionsFilter;
use App\Models\Auction;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('auctions.index',);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Auction $auction)
    {
        if (!$auction->approved || $auction->approved == null) {
            abort(404);
        }
        $auction->load('bids', 'creator', 'media', 'comments');


        return view('auctions.show', [
            'auction' => $auction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        //
    }

    //wonAuctions
    public function wonAuctions()
    {
        return view('auctions.won-auctions', [
            'auctions' => \Auth::user()->wonAuctions,
        ]);
    }
}
