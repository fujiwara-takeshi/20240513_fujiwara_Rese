@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <h2 class="content-title">予約照会ページ</h2>
    <table class="reservation-table">
        <tr>
            <th>店舗名</th>
            <td>{{ $reservation->shop->name }}</td>
        </tr>
        <tr>
            <th>予約名</th>
            <td>{{ $reservation->user->name }} 様</td>
        </tr>
        <tr>
            <th>予約日</th>
            <td>{{ $reservation->datetime->toDateString() }}</td>
        </tr>
        <tr>
            <th>予約時間</th>
            <td>{{ $reservation->datetime->toTimeString('minute') }}</td>
        </tr>
        <tr>
            <th>予約人数</th>
            <td>{{ $reservation->number }}名</td>
        </tr>
        <tr>
            <th>予約内容</th>
            @if($reservation->course_id === null)
                <td>席のみ予約</td>
            @else
                <td>{{ $reservation->course->amount }}円コース</td>
            @endif
        </tr>
    </table>
</div>
@endsection
