<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    /**
     * Create a new payment intent and return the client secret.
     */
    public function createPaymentIntent(Request $request)
    {
        // Set the Stripe API key from the .env file
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get the amount to charge from the request
        $amount = $request->input('amount');

        try {
            // Create a new PaymentIntent object
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount, // amount in cents (e.g., 5000 = $50.00)
                'currency' => 'usd', // you can change this to your preferred currency
                'payment_method_types' => ['card'],
            ]);

            // Return the client secret to the frontend
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);

        } catch (\Exception $e) {
            // Handle any errors that occur during payment creation
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
