<?php

namespace App\Livewire\Auctions;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public $auction;
    public $description; // This will hold the markdown content
    public $bid;
    public $comment;
    public $isfavorite;
    public $activities_per_load = 10;
    protected $listeners = ['bid-placed' => 'render'];

    public function mount()
    {
        $this->bid = $this->auction->minimum_bid;
        $this->description = $this->auction->description;
    }

    public function loadMoreActivities()
    {
        $this->activities_per_load += 10;
    }

    public function Bid(): void
    {
        $this->validate([
            'bid' => 'required|numeric|min:' . $this->auction->minimum_bid,
        ]);

        try {
            $this->auction->placeBid($this->bid);
        } catch (\Exception $e) {
            $this->dispatch('notify', content: $e->getMessage(), type: 'error');
            return;
        }

        $this->dispatch('notify', content: 'The Bid has been placed', type: 'success');


    }

    //buy now
    public function buyNow(): void
    {
        try {
            $this->auction->buyNow();
        } catch (\Exception $e) {
            $this->dispatch('notify', content: $e->getMessage(), type: 'error');
            return;
        }

        $this->dispatch('notify', content: 'The Bid has been placed', type: 'success');
    }


    //bid

    public function render()
    {
        //$favorite
        $this->isfavorite = $this->auction->favoritedBy()->where('user_id', Auth::id())->exists();


        return view('livewire.auctions.show',
            [
                'description' => $this->description,
                'activities' => $this->auction->activities()->take($this->activities_per_load),
            ]);
    }

    //render the component

    public function addcomment()
    {
        //create commant
        $this->validate([
            'comment' => 'required|min:3',
        ]);
        Auth::user()->comments()->create([
            'body' => $this->comment,
            'auction_id' => $this->auction->id,
        ]);
//        reset input
        $this->comment = '';
        $this->dispatch('notify', content: 'The comment has been added', type: 'success');
    }

    //Favorite
    public function favorite()
    {
        $this->auction->favoritedBy()->toggle(Auth::id());
    }

}
