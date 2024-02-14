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
        $categories = \App\Models\Category::with('auctions')->get();
        $auctions = Auction::where('approved', true)->with('media', 'bids')
            ->whereDate('end', '>', now()->subWeek())

        ;
        $filters = (new Request())->merge(
            [
                // get the filter keys and the values is the querey string if exist
                'price' => \request('price'),
                'min_bid' => \request('min_bid'),
                'end' => \request('end'),
                'buy_now' => \request('buy_now'),
                'category' => \request('category'),
            ]
        );
        $auctions = (new AuctionsFilter($filters))->apply($auctions)->get();
        return view('auctions.index', compact('auctions', 'categories'));
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
