<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\User;
use App\Http\Requests\ShopRequest;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $favorite_shop_ids = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
        $areas = Area::all();
        $genres = Genre::all();
        if ($request->has('keyword')) {
            $shops = Shop::with('area', 'genre')->AreaSearch($request->area_id)->GenreSearch($request->genre_id)->KeywordSearch($request->keyword)->get();
            return view('index', compact('user', 'favorite_shop_ids', 'shops', 'areas', 'genres'));
        }
        $shops = Shop::with('area', 'genre')->get();
        return view('index', compact('user', 'favorite_shop_ids', 'shops', 'areas', 'genres'));
    }

    public function show($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop_id);
        $reservation = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->orderBy('datetime', 'asc')->first();
        if ($reservation && $reservation->datetime <= now()) {
            $is_reserved = true;
            return view('detail', compact('user', 'shop', 'is_reserved'));
        }
        return view('detail', compact('user', 'shop'));
    }

    public function store(ShopRequest $request)
    {
        $image = $request->file('image');
        $path = $image->store('public/images');

        $shop = new Shop();
        if ($request->area_id === '新規エリア') {
            $area = Area::create(['area_name' => $request->area_name]);
            $shop->area_id = $area->id;
        } else {
            $shop->area_id = $request->area_id;
        }
        if ($request->genre_id === '新規ジャンル') {
            $genre = Genre::create(['genre_name' => $request->genre_name]);
            $shop->genre_id = $genre->id;
        } else {
            $shop->genre_id = $request->genre_id;
        }
        $shop->name = $request->shop_name;
        $shop->detail = $request->detail;
        $shop->image_path = $path;
        $shop->save();

        $user = User::find(Auth::id());
        $user->shop_id = $shop->id;
        $user->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '新規店舗情報を登録しました');
    }

    public function update($shop_id, ShopRequest $request)
    {
        $shop = Shop::find($shop_id);
        $image = $request->file('image');
        $path = $image->store('public/images');

        $shop->detail = $request->detail;
        $shop->image_path = $path;
        $shop->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '店舗情報を更新しました');
    }
}
