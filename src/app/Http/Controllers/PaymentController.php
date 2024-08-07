<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Exception;

class PaymentController extends Controller
{
    public function create($reservation_id)
    {
        return view('payment.create', compact('reservation_id'));
    }

    public function store(Request $request)
    {
        $reservation = Reservation::with('course')->find($request->reservation_id);
        $number = $reservation->number;
        $amount = $reservation->course->amount;
        \Stripe\Stripe::setApiKey(config('stripe.stripe_secret_key'));

        try {
            \Stripe\Charge::create([
                'source' => $request->stripeToken,
                'amount' => $amount * $number,
                'currency' => 'jpy',
            ]);
        } catch (Exception $e) {
            return back()->with('flash_alert', '決済に失敗しました！('. $e->getMessage() . ')');
        }
        $is_payment = true;
        return view('done', compact('is_payment'));
    }
}
