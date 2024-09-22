@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="content__block">
        <div class="content__left-outer">
            <div class="content__left-inner">
                <h1 class="content__title">今回のご利用はいかがでしたか？</h1>
                <div class="shop-card">
                    <div class="shop-card__img-box">
                        <img src="{{ $shop->getS3Url() }}" alt="Shop Image">
                    </div>
                    <div class="shop-card__about-box">
                        <div class="shop-card__about-text">
                            <p class="shop-card__about-name">{{ $shop->name }}</p>
                            <span class="shop-card__about-tag">#{{ $shop->area->area_name }}</span>
                            <span class="shop-card__about-tag">#{{ $shop->genre->genre_name }}</span>
                        </div>
                        <div class="shop-card__unit">
                            <a class="shop-card__link-detail" href="{{ route('shop.show', ['shop_id' => $shop->id]) }}">詳しくみる</a>
                            @isset($is_favorite)
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
            </div>
        </div>
        <div class="content__right-outer">
            <div class="content__right-inner">
                @isset($review)
                    <form class="review__form" id="review" action="{{ route('review.update', ['review_id' => $review->id]) }}" method="post" enctype="multipart/form-data">
                @else
                    <form class="review__form" id="review" action="{{ route('review.store') }}" method="post" enctype="multipart/form-data">
                @endisset
                    @csrf
                    @isset($review)
                        @method('patch')
                    @endisset
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                    <div class="review__form-item-block">
                        <h2 class="review__form-item-title">体験を評価してください</h2>
                        <div class="review__form-evaluation">
                            @isset($review)
                                <input class="review__form-evaluation-input" id="star5" name="evaluation" type="radio" value="5" {{ old('evaluation', $review->evaluation) == 5 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star5"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star4" name="evaluation" type="radio" value="4" {{ old('evaluation', $review->evaluation) == 4 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star4"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star3" name="evaluation" type="radio" value="3" {{ old('evaluation', $review->evaluation) == 3 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star3"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star2" name="evaluation" type="radio" value="2" {{ old('evaluation', $review->evaluation) == 2 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star2"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star1" name="evaluation" type="radio" value="1" {{ old('evaluation', $review->evaluation) == 1 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star1"><i class="material-symbols-outlined star">star</i></label>
                            @else
                                <input class="review__form-evaluation-input" id="star5" name="evaluation" type="radio" value="5" {{ old('evaluation') == 5 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star5"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star4" name="evaluation" type="radio" value="4" {{ old('evaluation') == 4 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star4"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star3" name="evaluation" type="radio" value="3" {{ old('evaluation') == 3 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star3"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star2" name="evaluation" type="radio" value="2" {{ old('evaluation') == 2 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star2"><i class="material-symbols-outlined star">star</i></label>
                                <input class="review__form-evaluation-input" id="star1" name="evaluation" type="radio" value="1" {{ old('evaluation') == 1 ? 'checked' : '' }}>
                                <label class="review__form-evaluation-label" for="star1"><i class="material-symbols-outlined star">star</i></label>
                            @endisset
                        </div>
                        <div class="form__item-error">
                            @error('evaluation')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="review__form-item-block">
                        <h2 class="review__form-item-title">口コミを投稿</h2>
                        <div class="review__form-comment">
                            @isset($review->comment)
                                <textarea class="review__form-comment-textarea" id="field" name="comment" rows="8">{{ $review->comment }}</textarea>
                            @else
                                <textarea class="review__form-comment-textarea" id="field" name="comment" rows="8">{{ old('comment') }}</textarea>
                            @endisset
                            <p class="review__form-comment-charcounter" id="result">0/400（最高文字数）</p>
                        </div>
                        <div class="form__item-error">
                            @error('comment')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="review__form-item-block">
                        @isset($review->image_path)
                            <h2 class="review__form-item-title">画像の変更</h2>
                        @else
                            <h2 class="review__form-item-title">画像の追加</h2>
                        @endisset
                        <div class="review__form-image-area">
                            @isset($review->image_path)
                                <img id="sample" src="{{ $review->getS3Url() }}" alt="sample image" style="max-width: 220px;">
                            @else
                                <img id="sample" style="max-width: 220px;">
                            @endisset
                            @isset($review->image_path)
                                <p class="form-image-area__text-top">クリックして写真を変更</p>
                            @else
                                <p class="form-image-area__text-top">クリックして写真を追加</p>
                            @endisset
                            <p class="form-image-area__text-bottom">またはドラッグアンドドロップ</p>
                            <input id="input-file" type="file" name="image" accept="image/jpeg, image/png">
                        </div>
                        <div class="form__item-error">
                            @error('image')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class="review__form-button" form="review">口コミを投稿</button>
</div>

<script>
const textarea = document.getElementById('field');
textarea.addEventListener('input', function() {
    const thisValue = this.value;
    const charCount = thisValue.length;
    document.getElementById('result').innerText = charCount + '/400（最高文字数）';
});

$("#input-file").on("change", function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $("#sample").attr("src", e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>
@endsection
