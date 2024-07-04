<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Shop;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index($user_id)
    {
        $user = User::with('reservedShops', 'favoriteShops')->where('id', $user_id)->first();
        $reserved_shops = $user->reservedShops()->orderBy('datetime', 'asc')->get();
        $reservations = [];
        $current_datetime = Carbon::now();
        foreach ($reserved_shops as $reserved_shop) {
            $datetime = Carbon::parse($reserved_shop->pivot->datetime);
            if ($datetime >= $current_datetime) {
                $reservation = [
                    'id' => $reserved_shop->pivot->id,
                    'shop' => $reserved_shop->name,
                    'date' => $datetime->toDateString(),
                    'time' => $datetime->toTimeString('minute'),
                    'number' => $reserved_shop->pivot->number
                ];
                array_push($reservations, $reservation);
            }
        }
        $favorites = $user->favoriteShops()->with('area', 'genre')->get();
        $shops = Shop::all();
        return view('mypage', compact('user', 'reservations', 'favorites', 'shops'));
    }

    public function create(Request $request)
    {
        
    }

    public function store()
    {

    }
}
