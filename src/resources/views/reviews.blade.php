@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reviews.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="detail">
        <div class="detail__top">
            <a class="detail-top__back-link" href="#" onclick="history.back()" return false;><</a>
            <h2 class="detail-top__shop-name">{{ $shop->name }}</h2>
        </div>
        <div class="detail__img-box">
            <img src="{{ $shop->getS3Url() }}" alt="Shop Image" height="300px">
        </div>
        <div class="detail__about">
            <div class="detail-about__tag">
                <span class="detail-about__tag-area">#{{ $shop->area->area_name }}</span>
                <span class="detail-about__tag-genre">#{{ $shop->genre->genre_name }}</span>
            </div>
            <div class="detail-about__text-box">
                <p class="detail-about__text">{{ $shop->detail }}</p>
            </div>
        </div>
    </div>
    <div class="reviews">
        <h2 class="reviews__title">口コミ一覧</h2>
        @foreach($reviews as $review)
            <div class="review">
                <div class="review__top">
                    <div class="review-top__left-box">
                        <p class="review__user-name">{{ $review->user->name }}</p>
                    </div>
                    <div class="review-top__right-box">
                        @if($review->user_id === $user->id)
                            <a class="review__update-link" href="{{ route('review.edit', ['review_id' => $review->id]) }}">口コミを編集</a>
                        @endif
                        @if($review->user_id === $user->id || $user->role_id === 2)
                            <form class="review__delete-form" action="{{ route('review.destroy', ['review_id' => $review->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="review__delete-button">口コミを削除</button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="review__evaluation">
                    @switch($review->evaluation)
                        @case(1)
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            @break
                        @case(2)
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            @break
                        @case(3)
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            @break
                        @case(4)
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star">star</i>
                            @break
                        @case(5)
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            <i class="material-symbols-outlined star checked">star</i>
                            @break
                        @default
                            <p>この評価値は読み込みできません</p>
                    @endswitch
                </div>
                <p class="review__comment">{{ $review->comment }}</p>
                @isset($review->image_path)
                    <img class="review__image" src="{{ $review->getS3Url() }}" alt="review image">
                @endisset
            </div>
        @endforeach
    </div>
    <div class="reviews__pagination">
        {{ $reviews->onEachSide(1)->links() }}
    </div>
</div>
@endsection