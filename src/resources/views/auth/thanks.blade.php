@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="message__box">
        <p class="message__text">会員登録ありがとうございます</p>
        <a class="message__link" href="{{ route('login') }}">ログインする</a>
    </div>
</div>
@endsection