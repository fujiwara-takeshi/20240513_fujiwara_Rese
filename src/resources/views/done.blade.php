@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="message__box">
        <p class="message__text">ご予約ありがとうございます</p>
        <a class="message__link" href="">戻る</a>
    </div>
</div>
@endsection