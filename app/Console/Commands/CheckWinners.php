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
        // Log information about the task
        $this->info('Checking winners...');

        // Get all auctions that have ended and don't have a winner yet
        $auctions = Auction::where('end', '<', now())->whereNull('winner_id')->get();

        // Loop through each auction
        foreach ($auctions as $auction) {
            // Log information about the current auction
            $this->info('Checking auction: ' . $auction->title);

            // Get all the bids for this auction, ordered by amount in descending order
            $bids = $auction->bids()->orderBy('amount', 'desc')->get();

            // If there are no bids, skip this auction
            if ($bids->count() === 0) {
                $this->info('No bids for this auction');
                continue;
            }

            // Get the highest bid
            $highestBid = $bids->first();

            // Set the winner and generate a random winner code
            $auction->winner_id = $highestBid->user_id;
            $auction->winner_code = Str::random(10);
            $auction->save();

            // Withdraw the winning amount from the winner's account
            $highestBid->user->withdraw($highestBid->amount);

            // Notify the winner through an event
            event(new AuctionWinner($highestBid->user_id, $auction->id));

            // Notify the winner via email
            $highestBid->user->notify(new NotifyAuctionWinner($auction));

            // Log information about the winner
            $this->info('Winner is: ' . $highestBid->user->name);
        }

        // Log completion of the task
        $this->info('Done!');
    }
}
