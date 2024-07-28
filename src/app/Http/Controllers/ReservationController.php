<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Shop;
use App\Http\Requests\ReservationRequest;


class ReservationController extends Controller
{
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation();
        $reservation->user_id = Auth::id();
        $reservation->shop_id = $request->shop_id;
        $reservation->datetime = Carbon::parse($request->date . $request->time);
        $reservation->number = $request->number;
        $reservation->save();
        return view('done');
    }

    public function show($reservation_id)
    {
        $reservation = Reservation::with('shop', 'user')->find($reservation_id);
        return view('reservation', compact('reservation'));
    }

    public function destroy($reservation_id)
    {
        Reservation::find($reservation_id)->delete();
        return back();
    }

    public function edit($reservation_id)
    {
        $reservation = Reservation::find($reservation_id);
        $shop = Shop::with('area', 'genre')->find($item->shop_id);
        return view('detail', compact('reservation', 'shop'));
    }

    public function update($reservation_id, ReservationRequest $request)
    {
        $reservation = Reservation::find($reservation_id);
        $reservation->datetime = Carbon::parse($request->date . $request->time);
        $reservation->number = $request->number;
        $reservation->save();
        return redirect()->route('user.index', ['user_id' => Auth::id()]);
    }
}
