<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\User;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Course;
use App\Http\Requests\RegisterRequest;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index($user_id, Request $request)
    {
        if ($user_id == Auth::id()) {
            $user = User::with('reservedShops', 'favoriteShops')->where('id', $user_id)->first();
            if ($user->role_id === 1) {
                $reserved_shops = $user->reservedShops()->where('datetime', '>=', now())->orderBy('datetime', 'asc')->get();
                $favorites = $user->favoriteShops()->with('area', 'genre')->get();
                return view('mypage', compact('user', 'reserved_shops', 'favorites'));
            } elseif ($user->role_id === 2) {
                $shops = Shop::all();
                $sender = User::find($request->sender);
                return view('mypage', compact('user', 'shops', 'sender'));
            } else {
                $store_in_charge = Shop::with('reservedUsers', 'area', 'genre')->where('id', $user->shop_id)->first();
                $sender = User::find($request->sender);
                if (isset($store_in_charge)) {
                    $reserved_users = $store_in_charge->reservedUsers()->where('datetime', '>=', now())->orderBy('datetime', 'asc')->get();
                    foreach ($reserved_users as $reserved_user) {
                        if ($reserved_user->pivot->course_id !== null) {
                            $amount = Course::find($reserved_user->pivot->course_id)->amount;
                            $reserved_user['amount'] = $amount;
                        }
                    }
                    $perPage = 10;
                    $page = Paginator::resolveCurrentPage('page');
                    $pageData = $reserved_users->slice(($page - 1) * $perPage, $perPage);
                    $options = [
                        'path' => Paginator::resolveCurrentPath(),
                        'pageName' => 'page'
                    ];
                    $reservations = new LengthAwarePaginator($pageData, $reserved_users->count(), $perPage, $page, $options);
                    return view('mypage', compact('user', 'store_in_charge', 'sender', 'reservations'));
                } else {
                    $areas = Area::all();
                    $genres = Genre::all();
                    return view('mypage', compact('user', 'store_in_charge', 'sender', 'areas', 'genres'));
                }
            }
        } else {
            return view('mypage');
        }
    }

    public function store(RegisterRequest $request)
    {
        $user = new User();
        $user->role_id = 3;
        $user->shop_id = $request->shop_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '店舗代表者を登録しました');
    }

    public function users(Request $request)
    {
        if ($request->has('keyword')) {
            $customers = User::where('role_id', 1)->KeywordSearch($request->keyword)->simplePaginate(10);
            return view('users', compact('customers'));
        }
        $customers = User::where('role_id', 1)->simplePaginate(10);
        return view('users', compact('customers'));
    }
}
