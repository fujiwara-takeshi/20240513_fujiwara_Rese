<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Shop;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Favorite;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function create($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::with('area', 'genre')->find($shop_id);
        $is_favorite = Favorite::where('user_id', $user->id)->where('shop_id', $shop_id)->first();
        return view('review', compact('user', 'shop', 'is_favorite'));
    }

    public function store(ReviewRequest $request)
    {
        $review = new Review();

        if($request->image) {
            $file = $request->file('image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('s3')->putFileAs('images/reviews', $file, $file_name);
            $review->image_path = "images/reviews/{$file_name}";
        }

        $review->user_id = $request->user_id;
        $review->shop_id = $request->shop_id;
        $review->evaluation = $request->evaluation;
        $review->comment = $request->comment;
        $review->save();
        $is_review = true;
        return view('done', compact('is_review'));
    }

    public function destroy($review_id)
    {
        Review::find($review_id)->delete();
        return back();
    }

    public function edit($review_id)
    {
        $user = Auth::user();
        $review = Review::find($review_id);
        $shop = Shop::with('area', 'genre')->find($review->shop_id);
        $is_favorite = Favorite::where('user_id', $user->id)->where('shop_id', $shop->id)->first();
        return view('review', compact('user', 'review', 'shop', 'is_favorite'));
    }

    public function update($review_id, ReviewRequest $request)
    {
        $review = Review::find($review_id);

        if($request->image) {
            $file = $request->file('image');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $path = Storage::disk('s3')->putFileAs('images/reviews', $file, $file_name);
            $review->image_path = "images/reviews/{$file_name}";
        }

        $review->evaluation = $request->evaluation;
        $review->comment = $request->comment;
        $review->save();
        return redirect()->route('shop.show', ['shop_id' => $review->shop_id]);
    }

    public function reviews($shop_id)
    {
        $user = Auth::user();
        $shop = Shop::find($shop_id);
        $reviews = Review::with('user')->where('shop_id', $shop_id)->orderBy('updated_at', 'desc')->paginate(10);
        return view('reviews', compact('user', 'shop', 'reviews'));
    }
}
