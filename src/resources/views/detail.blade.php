@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="detail">
        <div class="detail__top">
            <a class="detail-top__back-link" href="#" onclick="history.back()" return false;><</a>
            <h2 class="detail-top__shop-name">{{ $shop->name }}</h2>
        </div>
        <div class="detail__img-box">
            <img src="{{ Storage::url($shop->image_path) }}" alt="Shop Image">
        </div>
        <div class="detail__about">
            <div class="detail-about__tag">
                <span class="detail-about__tag-area">#{{ $shop->area->name }}</span>
                <span class="detail-about__tag-genre">#{{ $shop->genre->name }}</span>
            </div>
            <div class="detail-about__text-box">
                <p class="detail-about__text">{{ $shop->detail }}</p>
            </div>
        </div>
    </div>
    <div class="reservation">
        @isset($reservation)
            <form class="reservation__form" action="{{ route('reservation.update', ['reservation_id' => $reservation['id']]) }}" method="post">
                @csrf
                @method('patch')
                <div class="reservation__top">
                    <h2 class="reservation__title">予約変更</h2>
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
                            <option value="1人">1人</option>
                            <option value="2人">2人</option>
                            <option value="3人">3人</option>
                            <option value="4人">4人</option>
                            <option value="5人">5人</option>
                            <option value="6人">6人</option>
                            <option value="7人">7人</option>
                            <option value="8人">8人</option>
                            <option value="9人">9人</option>
                            <option value="10人">10人</option>
                            <option value="11人">11人</option>
                            <option value="12人">12人</option>
                            <option value="13人">13人</option>
                            <option value="14人">14人</option>
                            <option value="15人">15人</option>
                            <option value="16人">16人</option>
                            <option value="17人">17人</option>
                            <option value="18人">18人</option>
                            <option value="19人">19人</option>
                            <option value="20人">20人</option>
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
                <div class="reservation__bottom">
                    <button class="form__button">予約変更する</button>
                </div>
            </form>
        @else
            <form class="reservation__form" action="{{ route('reservation.store') }}" method="post">
                @csrf
                <div class="reservation__top" style="padding-bottom: 240px;">
                    <h2 class="reservation__title">予約</h2>
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
                            <option value="1人">1人</option>
                            <option value="2人">2人</option>
                            <option value="3人">3人</option>
                            <option value="4人">4人</option>
                            <option value="5人">5人</option>
                            <option value="6人">6人</option>
                            <option value="7人">7人</option>
                            <option value="8人">8人</option>
                            <option value="9人">9人</option>
                            <option value="10人">10人</option>
                            <option value="11人">11人</option>
                            <option value="12人">12人</option>
                            <option value="13人">13人</option>
                            <option value="14人">14人</option>
                            <option value="15人">15人</option>
                            <option value="16人">16人</option>
                            <option value="17人">17人</option>
                            <option value="18人">18人</option>
                            <option value="19人">19人</option>
                            <option value="20人">20人</option>
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
                <div class="reservation__bottom">
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
        // document.getElementById("date").setAttribute("value", today);
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