<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Favorite;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Review;
use App\Http\Requests\ShopRequest;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $favorite_shop_ids = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
        $areas = Area::all();
        $genres = Genre::all();
        $area_id = $request->area_id;
        $genre_id = $request->genre_id;
        $keyword = $request->keyword;
        $sort = $request->sort;
        switch($sort) {
            case '1':
                $shops = Shop::with('area', 'genre')->inRandomOrder()->get();
                break;
            case '2':
                $shops = Shop::with('area', 'genre', 'reviews')->get();
                foreach($shops as $shop) {
                    $evaluations = [];
                    foreach($shop->reviews as $review) {
                        array_push($evaluations, $review->evaluation);
                    }
                    if (count($evaluations)) {
                        $avg_evaluations = array_sum($evaluations) / count($evaluations);
                    } else {
                        $avg_evaluations = null;
                    }
                    $shop->avg_evaluations = $avg_evaluations;
                }

                $shops = $shops->sortByDesc(function($item, $key) {
                    return $item->avg_evaluations === null ? PHP_FLOAT_MIN : $item->avg_evaluations;
                })->values();
                break;
            case '3':
                $shops = Shop::with('area', 'genre', 'reviews')->get();
                foreach($shops as $shop) {
                    $evaluations = [];
                    foreach($shop->reviews as $review) {
                        array_push($evaluations, $review->evaluation);
                    }
                    if (count($evaluations)) {
                        $avg_evaluations = array_sum($evaluations) / count($evaluations);
                    } else {
                        $avg_evaluations = null;
                    }
                    $shop->avg_evaluations = $avg_evaluations;
                }
                $shops = $shops->sortBy(function($item, $key) {
                    return $item->avg_evaluations === null ? PHP_FLOAT_MAX : $item->avg_evaluations;
                })->values();
                break;
            default :
                $shops = Shop::with('area', 'genre')->get();
        }
        if ($request->has('keyword')) {
            $shops = Shop::with('area', 'genre')->AreaSearch($area_id)->GenreSearch($genre_id)->KeywordSearch($keyword)->get();
        }
        return view('index', compact('user', 'favorite_shop_ids', 'shops', 'areas', 'genres', 'area_id', 'genre_id', 'sort', 'keyword'));
    }

    public function show($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop_id);
        $reservation = Reservation::where('user_id', $user->id)->where('shop_id', $shop_id)->orderBy('datetime', 'asc')->first();
        $review = Review::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        if ($reservation && $reservation->datetime <= now()) {
            $is_reserved = true;
            return view('detail', compact('user', 'shop', 'is_reserved', 'review'));
        }
        return view('detail', compact('user', 'shop'));
    }

    public function store(ShopRequest $request)
    {
        $file = $request->file('image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs('images/shops/', $file, $file_name);

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
        $shop->image_path = "images/shops/{$file_name}";
        $shop->save();

        $user = User::find(Auth::id());
        $user->shop_id = $shop->id;
        $user->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '新規店舗情報を登録しました');
    }

    public function update($shop_id, ShopRequest $request)
    {
        $shop = Shop::find($shop_id);
        $file = $request->file('image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $path = Storage::disk('s3')->putFileAs('images/shops/', $file, $file_name);

        $shop->detail = $request->detail;
        $shop->image_path = "images/shops/{$file_name}";
        $shop->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '店舗情報を更新しました');
    }
}
