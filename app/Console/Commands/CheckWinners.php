<?php

namespace App\Console\Commands;

use App\Events\AuctionWinner;
use App\Models\Auction;
use App\Notifications\NotifyAuctionWinner;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
//        // Log information about the task
//        $this->info('Checking winners...');
//
//        // Get all auctions that have ended and don't have a winner yet
//        $auctions = Auction::where('end', '<', now())->whereNull('winner_id')->get();
//
//        // Loop through each auction
//        foreach ($auctions as $auction) {
//            // Log information about the current auction
//            $this->info('Checking auction: ' . $auction->title);
//
//
//
//            // Log information about the winner
//            $this->info('Winner is: ' . $highestBid->user->name);
//        }
//
//        // Log completion of the task
//        $this->info('Done!');
    }
}
