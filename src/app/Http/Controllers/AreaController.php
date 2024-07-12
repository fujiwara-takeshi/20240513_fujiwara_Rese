<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Area;
use App\Http\Requests\AreaRequest;

class AreaController extends Controller
{
    public function store(AreaRequest $request)
    {
        $area = new Area();
        $area->area_name = $request->area_name;
        $area->save();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', '新規エリア情報を登録しました');
    }
}
