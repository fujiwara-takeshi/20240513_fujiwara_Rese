@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="content__top">
        <h2 class="content__top-title">{{ $user->name }}さん</h2>
    </div>
    @if($user->role_id === 1)
        <div class="content__user">
            <div class="reservations">
                <h3 class="reservations__title">予約状況</h3>
                @foreach($reservations as $reservation)
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
                                    <form class="reservation__cancel-form" action="{{ route('reservation.destroy', ['reservation_id' => $reservation['id']]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="cancel-form__button">×</button>
                                    </form>
                                </div>
                            </div>
                            <table class="reservation__table">
                                <tr>
                                    <th>Shop</th>
                                    <td>{{ $reservation['shop'] }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $reservation['date'] }}</td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td>{{ $reservation['time'] }}</td>
                                </tr>
                                <tr>
                                    <th>Number</th>
                                    <td>{{ $reservation['number'] }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="reservation__bottom">
                            <form class="reservation__update-form" action="{{ route('reservation.edit', ['reservation_id' => $reservation['id']]) }}" method="get">
                                @csrf
                                <button class="update-form__button">予約変更</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="favorites">
                <h3 class="favorites__title">お気に入り店舗</h3>
                <div class="favorites__card-box">
                    @foreach($favorites as $favorite)
                        <div class="shop-card">
                            <div class="shop-card__img-box">
                                <img src="{{ Storage::url($favorite->image_path) }}" alt="Shop Image">
                            </div>
                            <div class="shop-card__about-box">
                                <div class="shop-card__about-text">
                                    <p class="shop-card__about-name">{{ $favorite->name }}</p>
                                    <span class="shop-card__about-tag">#{{ $favorite->area->name }}</span>
                                    <span class="shop-card__about-tag">#{{ $favorite->genre->name }}</span>
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
            <div class="create-representative">
                <h3 class="create-representative__title">店舗代表者作成</h3>
                <form class="create-representative__form" action="{{ route('user.store') }}" method="post">
                    @csrf
                    <ul>
                        <li>
                            <label for="shop">担当店舗：</label>
                            <select class="create-representative__form-item-select" name="shop_id" id="shop">
                                <option selected disabled hidden>担当店舗を選択</option>
                                <option value="">新規店舗</option>
                                @foreach($shops as $shop)
                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                            <label for="name">名前：</label>
                            <input class="create-representative__form-item-input" id="name" type="text" name="name">
                        </li>
                        <li>
                            <label for="email">メールアドレス：</label>
                            <input class="create-representative__form-item-input" id="email" type="text" name="email">
                        </li>
                        <li>
                            <label for="password">パスワード：</label>
                            <input class="create-representative__form-item-input" id="password" type="text" name="password">
                        </li>
                        <button class="create-representative__form-button">作成</button>
                    </ul>
                </form>
            </div>
            <div class="email">
                <h3 class="email__title">メールフォーム</h3>
            </div>
        </div>
    @endif
</div>
@endsection