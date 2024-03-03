<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    //create,, convert user to seller
    public function create(Request $request)
    {

        //validate password is the user's password
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);


        //check if user is already a seller
        if (auth()->user()->type == 'seller') {
            return redirect()->route('auctions.index')->with('info', 'You are already a seller');
        }
        //create a seller
        auth()->user()->becomeSeller();
        return redirect('/seller')->with('success', 'You are now a seller');
    }
}
