<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reservation;


class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->shop_id = $request->shop_id;
        $reservation->datetime = Carbon::parse($request->date . $request->time);
        $reservation->number = $request->number;
        $reservation->save();
        return view('done');
    }

    public function destroy($reservation_id)
    {
        Reservation::find($reservation_id)->delete();
        return back();
    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
