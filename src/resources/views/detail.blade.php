@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="detail">
        <div class="detail__top">
            <div class="detail-top__left-inner">
                <a class="detail-top__back-link" href="#" onclick="history.back()" return false;><</a>
                <h2 class="detail-top__shop-name">{{ $shop->name }}</h2>
            </div>
            <div class="detail-top__right-inner">
                @isset($is_reserved)
                    <a class="detail-top__review-link" href="{{ route('review.create', ['shop_id' => $shop->id]) }}">レビューする</a>
                @endisset
            </div>
        </div>
        <div class="detail__img-box">
            <img src="{{ Storage::url($shop->image_path) }}" alt="Shop Image">
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
    <div class="form">
        @if(isset($reservation))
            <form class="reservation__update-form" action="{{ route('reservation.update', ['reservation_id' => $reservation->id]) }}" method="post">
                @csrf
                @method('patch')
                <div class="form__top">
                    <h2 class="form__title">予約変更</h2>
                    <div class="reservation__form-items">
                        <input class="form__item-input" id="date" type="date" name="date" value="" oninput="updateDate()">
                        <div class="form__item-error">
                            @error('date')
                                {{ $message }}
                            @enderror
                        </div>
                        <select class="form__item-select" id="time" name="time" oninput="updateTime()">
                            <option selected disabled hidden>予約時間を選択</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                            <option value="19:30">19:30</option>
                            <option value="20:00">20:00</option>
                            <option value="20:30">20:30</option>
                            <option value="21:00">21:00</option>
                            <option value="21:30">21:30</option>
                            <option value="22:00">22:00</option>
                            <option value="22:30">22:30</option>
                            <option value="23:00">23:00</option>
                        </select>
                        <div class="form__item-error">
                            @error('time')
                                {{ $message }}
                            @enderror
                        </div>
                        <select class="form__item-select" id="number" name="number" oninput="updateNumber()">
                            <option selected disabled hidden>予約人数を選択</option>
                            <option value="1名">1名</option>
                            <option value="2名">2名</option>
                            <option value="3名">3名</option>
                            <option value="4名">4名</option>
                            <option value="5名">5名</option>
                            <option value="6名">6名</option>
                            <option value="7名">7名</option>
                            <option value="8名">8名</option>
                            <option value="9名">9名</option>
                            <option value="10名">10名</option>
                            <option value="11名">11名</option>
                            <option value="12名">12名</option>
                            <option value="13名">13名</option>
                            <option value="14名">14名</option>
                            <option value="15名">15名</option>
                            <option value="16名">16名</option>
                            <option value="17名">17名</option>
                            <option value="18名">18名</option>
                            <option value="19名">19名</option>
                            <option value="20名">20名</option>
                        </select>
                        <div class="form__item-error">
                            @error('number')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="reservation__box">
                        <h3 class="reservation__title">変更前</h3>
                        <div class="reservation__item">
                            <table class="reservation__table">
                                <tr>
                                    <th>Shop</th>
                                    <td>{{ $shop->name }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $reservation->datetime->toDateString() }}</td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td>{{ $reservation->datetime->toTimeString('minute') }}</td>
                                </tr>
                                <tr>
                                    <th>Number</th>
                                    <td>{{ $reservation->number }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="reservation__box">
                        <h3 class="reservation__title">変更後</h3>
                        <div class="reservation__item">
                            <table class="reservation__table">
                                <tr>
                                    <th>Shop</th>
                                    <td>{{ $shop->name }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td id="display_date"></td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td id="display_time"></td>
                                </tr>
                                <tr>
                                    <th>Number</th>
                                    <td id="display_number"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form__bottom">
                    <button class="form__button">予約変更する</button>
                </div>
            </form>
        @elseif(isset($is_review))
            <form class="review__store-form" action="{{ route('review.store') }}" method="post">
                @csrf
                <div class="form__top form__top--store-review">
                    <h2 class="form__title">レビュー投稿</h2>
                    <div class="review__form-items">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <select class="form__item-select" name="evaluation">
                            <option selected disabled hidden>評価を選択してください</option>
                            <option value="1">☆1</option>
                            <option value="2">☆2</option>
                            <option value="3">☆3</option>
                            <option value="4">☆4</option>
                            <option value="5">☆5</option>
                        </select>
                        <div class="form__item-error">
                            @error('evaluation')
                                {{ $message }}
                            @enderror
                        </div>
                        <textarea class="form__item-textarea" name="comment" rows="6" placeholder="コメントを記入してください（任意）"></textarea>
                        <div class="form__item-error">
                            @error('comment')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form__bottom">
                    <button class="form__button">投稿する</button>
                </div>
            </form>
        @else
            <form class="reservation__store-form" action="{{ route('reservation.store') }}" method="post">
                @csrf
                <div class="form__top form__top--store-reservation">
                    <h2 class="form__title">予約</h2>
                    <div class="reservation__form-items">
                        <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                        <input class="form__item-input" id="date" type="date" name="date" value="" min="" oninput="updateDate()">
                        <div class="form__item-error">
                            @error('date')
                                {{ $message }}
                            @enderror
                        </div>
                        <select class="form__item-select" id="time" name="time" oninput="updateTime()">
                            <option selected disabled hidden>予約時間を選択</option>
                            <option value="10:00">10:00</option>
                            <option value="10:30">10:30</option>
                            <option value="11:00">11:00</option>
                            <option value="11:30">11:30</option>
                            <option value="12:00">12:00</option>
                            <option value="12:30">12:30</option>
                            <option value="13:00">13:00</option>
                            <option value="13:30">13:30</option>
                            <option value="14:00">14:00</option>
                            <option value="14:30">14:30</option>
                            <option value="15:00">15:00</option>
                            <option value="15:30">15:30</option>
                            <option value="16:00">16:00</option>
                            <option value="16:30">16:30</option>
                            <option value="17:00">17:00</option>
                            <option value="17:30">17:30</option>
                            <option value="18:00">18:00</option>
                            <option value="18:30">18:30</option>
                            <option value="19:00">19:00</option>
                            <option value="19:30">19:30</option>
                            <option value="20:00">20:00</option>
                            <option value="20:30">20:30</option>
                            <option value="21:00">21:00</option>
                            <option value="21:30">21:30</option>
                            <option value="22:00">22:00</option>
                            <option value="22:30">22:30</option>
                            <option value="23:00">23:00</option>
                            <option value="23:30">23:30</option>
                            <option value="24:00">24:00</option>
                        </select>
                        <div class="form__item-error">
                            @error('time')
                                {{ $message }}
                            @enderror
                        </div>
                        <select class="form__item-select" id="number" name="number" oninput="updateNumber()">
                            <option selected disabled hidden>予約人数を選択</option>
                            <option value="1名">1名</option>
                            <option value="2名">2名</option>
                            <option value="3名">3名</option>
                            <option value="4名">4名</option>
                            <option value="5名">5名</option>
                            <option value="6名">6名</option>
                            <option value="7名">7名</option>
                            <option value="8名">8名</option>
                            <option value="9名">9名</option>
                            <option value="10名">10名</option>
                            <option value="11名">11名</option>
                            <option value="12名">12名</option>
                            <option value="13名">13名</option>
                            <option value="14名">14名</option>
                            <option value="15名">15名</option>
                            <option value="16名">16名</option>
                            <option value="17名">17名</option>
                            <option value="18名">18名</option>
                            <option value="19名">19名</option>
                            <option value="20名">20名</option>
                        </select>
                        <div class="form__item-error">
                            @error('number')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="reservation__item">
                        <table class="reservation__table">
                            <tr>
                                <th>Shop</th>
                                <td>{{ $shop->name }}</td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td id="display_date"></td>
                            </tr>
                            <tr>
                                <th>Time</th>
                                <td id="display_time"></td>
                            </tr>
                            <tr>
                                <th>Number</th>
                                <td id="display_number"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="form__bottom">
                    <button class="form__button">予約する</button>
                </div>
            </form>
        @endisset
    </div>
</div>

<script>
    window.onload = function() {
        var getToday = new Date();
        var y = getToday.getFullYear();
        var m = getToday.getMonth() + 1;
        var d = getToday.getDate();
        var today = y + "-" + m.toString().padStart(2,'0') + "-" + d.toString().padStart(2,'0');
        document.getElementById("date").setAttribute("min", today);
    }
    function updateDate() {
        var input = document.getElementById('date');
        var display = document.getElementById('display_date');
        display.textContent = input.value;
    }
    function updateTime() {
        var input = document.getElementById('time');
        var display = document.getElementById('display_time');
        display.textContent = input.value;
    }
    function updateNumber() {
        var input = document.getElementById('number');
        var display = document.getElementById('display_number');
        display.textContent = input.value;
    }
</script>
@endsection