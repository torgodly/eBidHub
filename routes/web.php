<?php

use App\Events\MyEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [App\Http\Controllers\AuctionController::class, 'index'])->name('auctions.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //auctions
    //show
    Route::get('/auctions/{auction}', [App\Http\Controllers\AuctionController::class, 'show'])->name('auctions.show');

    //becom a seller
    Route::post('/become-seller', [App\Http\Controllers\SellerController::class, 'create'])->name('sellers.create');

    //favorite index
    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    //auction that user has won
    Route::get('/won-auctions', [App\Http\Controllers\AuctionController::class, 'wonAuctions'])->name('auctions.won-auctions');

});

//terms and conditions
Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
})->name('terms-and-conditions')->middleware(['guest']);
require __DIR__ . '/auth.php';
