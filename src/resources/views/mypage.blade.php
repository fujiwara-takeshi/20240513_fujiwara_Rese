@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="content__top">
        <h2 class="content__top-title">{{ $user->name }}さん</h2>
    </div>
    <div class="content__main">
        <div class="reservations">
            <h3 class="reservations__title">予約状況</h3>
            @foreach($reservations as $reservation)
                <div class="reservation-item">
                    <div class="reservation-item__top">
                        <div class="reservation-item__top-left-inner">
                            <svg class="icon-clock" xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px" fill="#365CFF">
                                <path d="m612-292 56-56-148-148v-184h-80v216l172 172ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q133 0 226.5-93.5T800-480q0-133-93.5-226.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160Z" fill="#fff"/>
                            </svg>
                            <span class="reservation-item__top-title">予約{{ $loop->iteration }}</span>
                        </div>
                        <div class="reservation-item__top-right-inner">
                            <form class="reservation__cancel-form" action="{{ route('reservation.destroy', ['reservation_id' => $reservation['id']]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="cancel-form__button">×</button>
                            </form>
                        </div>
                    </div>
                    <table class="reservation-item__table">
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
</div>
@endsection