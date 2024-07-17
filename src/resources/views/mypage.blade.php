@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    @if(!isset($user))
        <div class="content__alert alert--danger">
            不正なアクセスが行われました
        </div>
    @else
        <div class="content__top">
            <h2 class="content__top-title">{{ $user->name }}さん</h2>
        </div>
        @if($user->role_id === 1)
            <div class="content__user">
                <div class="reservations">
                    <h3 class="reservations__title" id="reservations__title">予約状況</h3>
                    @foreach($reserved_shops as $reserved)
                        <div class="reservation-item">
                            <div class="reservation__top">
                                <div class="reservation__top-header">
                                    <div class="reservation__top-header-left">
                                        <svg class="icon-clock" xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#365CFF">
                                            <path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z" fill="#fff"/>
                                        </svg>
                                        <span class="reservation__top-header-title">予約{{ $loop->iteration }}</span>
                                    </div>
                                    <div class="reservation__top-header-right">
                                        <form class="reservation__cancel-form" action="{{ route('reservation.destroy', ['reservation_id' => $reserved->pivot->id]) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button class="cancel-form__button">×</button>
                                        </form>
                                    </div>
                                </div>
                                <table class="reservation__table">
                                    <tr>
                                        <th>Shop</th>
                                        <td>{{ $reserved->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>{{ $reserved->pivot->datetime->toDateString() }}</td>
                                    </tr>
                                    <tr>
                                        <th>Time</th>
                                        <td>{{ $reserved->pivot->datetime->toTimeString('minute') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Number</th>
                                        <td>{{ $reserved->pivot->number }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="reservation__bottom">
                                <form class="reservation__update-form" action="{{ route('reservation.edit', ['reservation_id' => $reserved->pivot->id]) }}" method="get">
                                    @csrf
                                    <button class="update-form__button">予約変更</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="favorites">
                    <h3 class="favorites__title" id="favorites__title">お気に入り店舗</h3>
                    <div class="favorites__card-box">
                        @foreach($favorites as $favorite)
                            <div class="shop-card">
                                <div class="shop-card__img-box">
                                    <img src="{{ Storage::url($favorite->image_path) }}" alt="Shop Image">
                                </div>
                                <div class="shop-card__about-box">
                                    <div class="shop-card__about-text">
                                        <p class="shop-card__about-name">{{ $favorite->name }}</p>
                                        <span class="shop-card__about-tag">#{{ $favorite->area->area_name }}</span>
                                        <span class="shop-card__about-tag">#{{ $favorite->genre->area_name }}</span>
                                    </div>
                                    <div class="shop-card__unit">
                                        <a class="shop-card__link-detail" href="{{ route('shop.show', ['shop_id' => $favorite->id]) }}">詳しくみる</a>
                                        <form class="favorite__form-delete" action="{{ route('favorite.destroy') }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="shop_id" value="{{ $favorite->id }}">
                                            <button class="shop-card__button-favorite">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 -960 960 960" width="34px" fill="#EA3323">
                                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif($user->role_id === 2)
            <div class="content__admin">
                <div class="content__alert alert--success">
                    @if (session('success'))
                        {{ session('success') }}
                    @endif
                </div>
                <div class="create-representative">
                    <h3 class="create-representative__title">店舗代表者作成</h3>
                    <form class="create-representative__form" action="{{ route('user.store') }}" method="post">
                        @csrf
                        <ul>
                            <li>
                                <label for="shop_id">担当店舗<span class="label__span--red">※必須</span></label>
                                <select class="create-representative__form-item-select" name="shop_id" id="shop_id">
                                    <option selected disabled hidden>担当店舗を選択</option>
                                    <option value="">新規店舗</option>
                                    @foreach($shops as $shop)
                                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li>
                                <label for="name">名前<span class="label__span--red">※必須</span></label>
                                <input class="create-representative__form-item-input" id="name" type="text" name="name" value="{{ old('name') }}">
                                <div class="form__item-error">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </li>
                            <li>
                                <label for="email">メールアドレス<span class="label__span--red">※必須</span></label>
                                <input class="create-representative__form-item-input" id="email" type="text" name="email" value="{{ old('email') }}">
                                <div class="form__item-error">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </li>
                            <li>
                                <label for="password">パスワード<span class="label__span--red">※必須</span></label>
                                <input class="create-representative__form-item-input" id="password" type="text" name="password">
                                <div class="form__item-error">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </li>
                        </ul>
                        <button class="create-representative__form-button">登録</button>
                    </form>
                </div>
                <div class="email">
                    <h3 class="email__title">メールフォーム</h3>

                </div>
            </div>
        @else
            <div class="content__representative">
                <div class="content__alert alert--success">
                    @if (session('success'))
                        {{ session('success') }}
                    @endif
                </div>
                @isset($reserved_users)
                    <div class="reservations-by-shop">
                        <h3 class="reservations-by-shop__title">担当店舗予約情報</h3>
                        <table class="reservations-by-shop__table">
                            <tr>
                                <th>予約日</th>
                                <th>予約時間</th>
                                <th>予約人数</th>
                                <th>予約名</th>
                            </tr>
                            @foreach($reserved_users as $reservation)
                                <tr>
                                    <td>{{ $reservation->pivot->datetime->toDateString() }}</td>
                                    <td>{{ $reservation->pivot->datetime->toTimeString('minute') }}</td>
                                    <td>{{ $reservation->pivot->number }}</td>
                                    <td>{{ $reservation->name }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="pagination__reserved-users">
                            {{ $reserved_users->links() }}
                        </div>
                    </div>
                @endisset
                @isset($store_in_charge)
                    <div class="update-shop">
                        <h3 class="update-shop__title">店舗情報編集</h3>
                        <form class="update-shop__form" action="{{ route('shop.update', ['shop_id' => $store_in_charge->id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <ul>
                                <li>
                                    <label for="shop_name">担当店舗名<span class="label__span--red">※編集不可</span></label>
                                    <input class="update-shop__form-item-input" id="shop_name" type="text" name="shop_name" value="{{ $store_in_charge->name }}" readonly>
                                </li>
                                <li>
                                    <label for="area_id">エリア<span class="label__span--red">※編集不可</span></label>
                                    <input class="update-shop__form-item-input" id="area_id" type="text" name="area_id" value="{{ $store_in_charge->area->area_name }}" readonly>
                                </li>
                                <li>
                                    <label for="genre_id">ジャンル<span class="label__span--red">※編集不可</span></label>
                                    <input class="update-shop__form-item-input" id="genre_id" type="text" name="genre_id" value="{{ $store_in_charge->genre->genre_name }}" readonly>
                                </li>
                                <li>
                                    <label for="detail">店舗詳細<span class="label__span--red">※必須</span></label>
                                    <textarea class="update-shop__form-item-textarea" id="detail" rows="6" name="detail">{{ $store_in_charge->detail }}</textarea>
                                    <div class="form__item-error">
                                        @error('detail')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </li>
                                <li>
                                    <label for="image">画像アップロード<span class="label__span--red">※必須</span></label>
                                    <input class="update-shop__form-item-input" id="image" type="file"  name="image" value="{{ old('image') }}">
                                    <div class="form__item-error">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </li>
                            </ul>
                            <button class="update-shop__form-button">更新</button>
                        </form>
                    </div>
                    @else
                    <div class="create-shop">
                        <h3 class="create-shop__title">店舗情報作成</h3>
                        <div class="create-shop__form-block">
                            <h4 class="store-shop__form-title">新規店舗情報登録</h4>
                            <form class="store-shop__form" action="{{ route('shop.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <ul>
                                    <li>
                                        <label for="shop_name">担当店舗名<span class="label__span--red">※必須</span></label>
                                        <input class="store-shop__form-item-input" id="shop_name" type="text" name="shop_name" value="{{ old('shop_name') }}">
                                        <div class="form__item-error">
                                            @error('shop_name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="area_id">エリア<span class="label__span--red">※必須</span></label>
                                        <select class="store-shop__form-item-select" id="area_id" name="area_id">
                                            <option selected disabled hidden>エリアを選択</option>
                                            @foreach($areas as $area)
                                                <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form__item-error">
                                            @error('area_id')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="genre_id">ジャンル<span class="label__span--red">※必須</span></label>
                                        <select class="store-shop__form-item-select" name="genre_id" id="genre_id">
                                            <option selected disabled hidden>ジャンルを選択</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre->id }}">{{ $genre->genre_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="form__item-error">
                                            @error('genre_id')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="detail">店舗詳細<span class="label__span--red">※必須</span></label>
                                        <textarea class="store-shop__form-item-textarea" id="detail" rows="6" name="detail">{{ old('detail') }}</textarea>
                                        <div class="form__item-error">
                                            @error('detail')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                    <li>
                                        <label for="image">画像アップロード<span class="label__span--red">※必須</span></label>
                                        <input class="store-shop__form-item-input" id="image" type="file"  name="image" value="{{ old('image') }}">
                                        <div class="form__item-error">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                </ul>
                                <button class="store-shop__form-button">登録</button>
                            </form>
                        </div>
                        <div class="create-shop__form-block">
                            <h4 class="store-area__form-title">新規エリア情報登録</h4>
                            <form class="store-area__form" action="{{ route('area.store') }}" method="post">
                                @csrf
                                <ul>
                                    <li>
                                        <label for="area_name">エリア名<span class="label__span--red">※必須</span></label>
                                        <input class="store-area__form-item-input" id="area_name" type="text" name="area_name" value="{{ old('area_name') }}">
                                        <div class="form__item-error">
                                            @error('area_name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                </ul>
                                <button class="store-area__form-button">登録</button>
                            </form>
                        </div>
                        <div class="create-shop__form-block">
                            <h4 class="store-genre__form-title">新規ジャンル情報登録</h4>
                            <form class="store-genre__form" action="{{ route('genre.store') }}" method="post">
                                @csrf
                                <ul>
                                    <li>
                                        <label for="genre_name">ジャンル名<span class="label__span--red">※必須</span></label>
                                        <input class="store-genre__form-item-input" id="genre_name" type="text" name="genre_name" value="{{ old('genre_name') }}">
                                        <div class="form__item-error">
                                            @error('genre_name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </li>
                                </ul>
                                <button class="store-genre__form-button">登録</button>
                            </form>
                        </div>
                    </div>
                @endisset
                <div class="email">
                    <h3 class="email__title">メールフォーム</h3>
                    
                </div>
            </div>
        @endif
    @endif
</div>
@endsection