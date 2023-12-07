<?php

namespace App\Livewire\Auctions;

use Livewire\Component;

class Show extends Component
{
    public $auction;
    public $description; // This will hold the markdown content
    public $bid;

    public function mount()
    {
        $this->bid = $this->auction->minimum_bid;
        $this->description = $this->auction->description;
    }

    public function CreateBid()
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


    //bid

    public function render()
    {

        $this->auction->getActivitiesAttribute();

        return view('livewire.auctions.show',
            [
                'description' => $this->description,
            ]);
    }


}
