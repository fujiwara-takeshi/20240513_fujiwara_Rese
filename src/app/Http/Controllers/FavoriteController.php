<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function store(Request $request)
    {
        $favorite = new Favorite();
        $favorite->shop_id = $request->shop_id;
        $favorite->user_id = Auth::id();
        $favorite->save();
        return back();
    }

    public function destroy(Request $request)
    {
        $user_id = Auth::id();
        $shop_id = $request->shop_id;
        $favorite = Favorite::where('shop_id', $shop_id)->where('user_id', $user_id)->first();
        $favorite->delete();
        return back();
    }
}
