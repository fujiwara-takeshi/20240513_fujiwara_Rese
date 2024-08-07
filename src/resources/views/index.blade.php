@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header__inner-right')
<form class="search-form" action="{{ route('shop.index') }}" method="get">
    <select class="search-form__item-select" name="area_id">
        <option value="">All area</option>
        @foreach ($areas as $area)
            <option value="{{ $area->id }}">{{ $area->area_name }}</option>
        @endforeach
    </select>
    <select class="search-form__item-select" name="genre_id">
        <option value="">All genre</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}">{{ $genre->genre_name }}</option>
        @endforeach
    </select>
    <button class="search-form__item-button">
        <i class="material-symbols-outlined search-icon">search</i>
    </button>
    <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search ...">
</form>
@endsection

@section('content')
<div class="content__wrapper">
    @foreach($shops as $shop)
        <div class="shop-card">
            <div class="shop-card__img-box">
                <img src="{{ Storage::url($shop->image_path) }}" alt="Shop Image">
            </div>
            <div class="shop-card__about-box">
                <div class="shop-card__about-text">
                    <p class="shop-card__about-name">{{ $shop->name }}</p>
                    <span class="shop-card__about-tag">#{{ $shop->area->area_name }}</span>
                    <span class="shop-card__about-tag">#{{ $shop->genre->genre_name }}</span>
                </div>
                <div class="shop-card__unit">
                    <a class="shop-card__link-detail" href="{{ route('shop.show', ['shop_id' => $shop->id]) }}">詳しくみる</a>
                    @if(in_array($shop->id, $favorite_shop_ids))
                        <form class="favorite__form-delete" action="{{ route('favorite.destroy') }}" method="post">
                            @csrf
                            @method('delete')
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <button class="shop-card__button-favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 -960 960 960" width="34px" fill="#EA3323">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                </svg>
                            </button>
                        </form>
                    @else
                        <form class="favorite__form-post" action="{{ route('favorite.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                            <button class="shop-card__button-favorite">
                                <svg xmlns="http://www.w3.org/2000/svg" height="34px" viewBox="0 -960 960 960" width="34px" fill="#EFEFEF">
                                    <path d="m480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z"/>
                                </svg>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
