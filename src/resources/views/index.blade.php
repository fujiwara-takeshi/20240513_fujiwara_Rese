@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search')
<form class="search-form" action="">
    @csrf
    <select class="search-form__item-select" name="">
        <option value="">All area</option>
    </select>
    <select class="search-form__item-select" name="">
        <option value="">All genre</option>
    </select>
    <button class="search-form__item-button">
        <i class="material-symbols-outlined search-icon">search</i>
    </button>
    <input class="search-form__item-input" type="text" placeholder="Search ...">
</form>
@endsection

@section('content')
<div class="content__wrapper">
    <div class="shop-card">
        <div class="shop-card__img-box">
            <img src="" alt="">
        </div>
        <div class="shop-card__about-box">
            <div class="shop-card__about-top">
                <p class="shop-card__about-name">仙人</p>
            </div>
            <div class="shop-card__about-middle">
                <span class="shop-card__about-tag">#東京都</span>
                <span class="shop-card__about-tag">#寿司</span>
            </div>
            <div class="shop-card__about-bottom">
                <a class="shop-card__about-link" href="">詳しくみる</a>
                <i class="shop-card__about-favorite favorite-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#EFEFEF">
                        <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                    </svg>
                </i>
            </div>
        </div>
    </div>
</div>
@endsection
