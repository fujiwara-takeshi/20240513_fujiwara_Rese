@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<div class="content__wrapper">
    <div class="email-confirm">
        <h3 class="email-confirm__title">メール内容確認ページ</h3>
        <form class="email-confirm__form" action="{{ route('mail.send') }}" method="post" >
            @csrf
            <table class="email-confirm__table">
                <tr>
                    <th class="email-confirm__table-header">送信先：</th>
                    <td class="email-confirm__table-data">{{ $postarr['name'] }}</td>
                </tr>
                <tr>
                    <th class="email-confirm__table-header">メールアドレス：</th>
                    <td class="email-confirm__table-data">{{ $postarr['address'] }}</td>
                </tr>
                <tr>
                    <th class="email-confirm__table-header">件名：</th>
                    <td class="email-confirm__table-data">{{ $postarr['subject'] }}</td>
                </tr>
                <tr>
                    <th class="email-confirm__table-header">本文：</th>
                    <td class="email-confirm__table-data">{!! nl2br(e($postarr['message'])) !!}</td>
                </tr>
            </table>
            <div class="email-confirm__form-button-block">
                <button class="email-confirm__form-button-submit">送信</button>
                <a class="email-confirm__link-return" href="#" onclick="history.back()" return false;>戻る</a>
            </div>
                @foreach($postarr as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
        </form>
    </div>
</div>
@endsection
