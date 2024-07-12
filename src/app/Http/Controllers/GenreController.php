<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Genre;
use App\Http\Requests\GenreRequest;

class GenreController extends Controller
{
    public function store(GenreRequest $request)
    {
        $genre = new Genre();
        $genre->genre_name = $request->genre_name;
        $genre->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '新規ジャンル情報を登録しました');
    }
}
