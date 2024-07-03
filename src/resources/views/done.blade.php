@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="message__box">
        @isset($is_review)
            <p class="message__text">レビュー投稿ありがとうございます</p>
        @else
            <p class="message__text">ご予約ありがとうございます</p>
        @endif
        <a class="message__link" href="{{ route('shop.index') }}">戻る</a>
    </div>
</div>
@endsection