<?php

use App\Events\MyEvent;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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


Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //auctions
    Route::get('/', [App\Http\Controllers\AuctionController::class, 'index'])->name('auctions.index');
    //show
    Route::get('/auctions/{auction}', [App\Http\Controllers\AuctionController::class, 'show'])->name('auctions.show');

    //becom a seller
    Route::post('/become-seller', [App\Http\Controllers\SellerController::class, 'create'])->name('sellers.create');

});

//terms and conditions
Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions');
})->name('terms-and-conditions')->middleware(['guest']);
require __DIR__ . '/auth.php';
