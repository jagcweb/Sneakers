<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;

class StripePaymentController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function stripe(Request $request) {

        $address_id = $request->input('address_id');
        $observations = $request->get('observations');
        
        \Session::put('address_id', $address_id);

        if ($observations != null) {
            $validate = $this->validate($request, [
                'observations' => ['string', 'max:255'],
            ]);
            
            \Session::put('observations', $observations);
        }
        
        
        

        return view('stripe.stripe');
    }

    public function stripePost(Request $request) {

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        Stripe\Charge::create([
            "amount" => \CountCartItem::calcTotalPrice()['total_price'] * 100,
            "currency" => "eur",
            "source" => $request->stripeToken,
            "description" => "From ".\Auth::user()->email,
        ]);



        return redirect()->route('order.save');
    }

}
