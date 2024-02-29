<?php

namespace App\Livewire\Auctions;

use App\Filters\AuctionsFilter;
use App\Models\Auction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $price;
    public $min_bid;
    public $end;
    public $buy_now;
    public $category;
//    public $categories;
//    public $auctions;
    protected $queryString = [
        'price' => ['except' => ''],
        'min_bid' => ['except' => ''],
        'end' => ['except' => ''],
        'buy_now' => ['except' => ''],
        'category' => ['except' => ''],
    ];

    public function render()
    {
        $categories = \App\Models\Category::with('auctions')->get();
        $auctions = Auction::where('approved', true)->with('media', 'bids')
            ->whereDate('end', '>', now()->subWeek())
            ->orderBy('created_at', 'desc');
        $auctions = $this->applyFilters($auctions);
        $auctions = $auctions->paginate(10);


        return view('livewire.auctions.index', compact('auctions', 'categories'));
    }


    public function applyFilters(Builder $auctions)
    {

        $filters = (new Request())->merge(
            [
                'price' => $this->price,
                'min_bid' => $this->min_bid,
                'end' => $this->end,
                'buy_now' => $this->buy_now,
                'category' => $this->category,
            ]
        );
        return (new AuctionsFilter($filters))->apply($auctions);

    }
}
