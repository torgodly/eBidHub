<?php

namespace App\Console\Commands;

use App\Events\AuctionWinner;
use Illuminate\Console\Command;

class CheckWinners extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-winners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check winners';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking winners...');
        //check all the auctions that have ended an
        $auctions = \App\Models\Auction::where('end', '<', now())->whereNull('winner_id')->get();
        foreach ($auctions as $auction) {
            $this->info('Checking auction: ' . $auction->title);
            //get all the bids for this auction
            $bids = $auction->bids()->orderBy('amount', 'desc')->get();
            //if there are no bids, skip this auction
            if ($bids->count() === 0) {
                $this->info('No bids for this auction');
                continue;
            }
            //get the highest bid
            $highestBid = $bids->first();
            //set the winner
            $auction->winner_id = $highestBid->user_id;
            $auction->save();

            //take the money from the winner
            $highestBid->user->withdraw($highestBid->amount);
            //notify the winner
            event(new AuctionWinner($highestBid->user_id, $auction->id));

            $this->info('Winner is: ' . $highestBid->user->name);
        }
        $this->info('Done!');


    }
}
