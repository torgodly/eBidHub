<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    //store
    public function store(Request $request)
    {
        $data = request()->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required'
        ]);

        //make the first_name and last_name to be one field name
        $data['name'] = $data['first_name'] . ' ' . $data['last_name'];

        \App\Models\Message::create($data);
        return back()->with('message', __('Thank you for contacting us. We will get back to you soon.'));

    }

}
