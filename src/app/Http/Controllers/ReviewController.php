<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function create($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop_id);
        $is_review = true;
        return view('detail', compact('user', 'shop', 'is_review'));
    }

    public function store(ReviewRequest $request)
    {
        $review = new Review();
        $review->user_id = $request->user_id;
        $review->shop_id = $request->shop_id;
        $review->evaluation = $request->evaluation;
        $review->comment = $request->comment;
        $review->save();
        $is_review = true;
        return view('done', compact('is_review'));
    }
}
