<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Favorite;

class ShopController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $favorite_shop_ids = Favorite::where('user_id', $user->id)->pluck('shop_id')->toArray();
        $shops = Shop::with('area', 'genre')->get();
        return view('index', compact('user', 'favorite_shop_ids', 'shops'));
    }

    public function show($shop)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop);
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
