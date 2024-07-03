<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorite_shop_ids = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
        $shops = Shop::with('area', 'genre')->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('user', 'favorite_shop_ids', 'shops', 'areas', 'genres'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $favorite_shop_ids = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
        $shops = Shop::with('area', 'genre')->AreaSearch($request->area_id)->GenreSearch($request->genre_id)->KeywordSearch($request->keyword)->get();
        $areas = Area::all();
        $genres = Genre::all();
        return view('index', compact('user', 'favorite_shop_ids', 'shops', 'areas', 'genres'));
    }

    public function show($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop_id);
        $reservation = Reservation::where('shop_id', $shop_id)->orderBy('datetime', 'asc')->first();
        $current_datetime = Carbon::now();
        if ($reservation && $reservation->datetime <= $current_datetime) {
            $reservation_history = $reservation;
            return view('detail', compact('user', 'shop', 'reservation_history'));
        }
        return view('detail', compact('user', 'shop'));
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
