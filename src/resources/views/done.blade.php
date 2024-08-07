@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="message__box">
        @if(isset($is_review))
            <p class="message-text">レビュー投稿ありがとうございます</p>
        @else
            @isset($is_payment)
                <p class="message-success">決済に成功しました！</p>
            @endisset
            <p class="message-text">ご予約ありがとうございます</p>
        @endif
        <a class="message-link" href="{{ route('shop.index') }}">戻る</a>
    </div>
</div>
@endsection