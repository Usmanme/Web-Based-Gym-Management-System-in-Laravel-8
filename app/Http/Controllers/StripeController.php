<?php

namespace App\Http\Controllers;
use Stripe;
use Session;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function handleGet()
    {
       
        return view('home');
    }

    public function handlePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 1 * 15000,
                "currency" => "pkr",
                "source" => $request->stripeToken,
                "description" => "Making test payment." 
        ]);
  
        Session::flash('success', 'Payment has been successfully processed.');
       
        return back();

    }
}
