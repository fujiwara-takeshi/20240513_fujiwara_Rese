@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    @if(Auth::user()->role_id === 1 | Auth::user() === null)
        <div class="content__alert alert--danger">
            ご利用のアカウントではこのページは無効です
        </div>
    @else
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
                <td>{{ $reservation->number }}</td>
            </tr>
        </table>
    @endif
</div>
@endsection
