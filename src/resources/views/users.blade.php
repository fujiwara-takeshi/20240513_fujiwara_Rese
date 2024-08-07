@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/users.css') }}">
@endsection

@section('header__inner-right')
<form class="search-form" action="{{ route('users') }}" method="get">
    <button class="search-form__item-button">
        <i class="material-symbols-outlined search-icon">search</i>
    </button>
    <input class="search-form__item-input" type="text" name="keyword" value="{{ old('keyword') }}" placeholder="Search ...">
</form>

@endsection

@section('content')
<div class="content__wrapper">
    @if(Auth::user()->role_id === 1)
        <div class="content__alert alert--danger">
            不正なアクセスが行われました
        </div>
    @endif
    <div class="content-top">
        <a class="content-top__back-link" href="{{ route('user.index', ['user_id' => Auth::id()]) }}"><</a>
        <h2 class="content-top__title">利用者ユーザー一覧</h2>
    </div>
    <table class="customer-users__table">
        <tr>
            <th>お名前</th>
            <th>メールアドレス</th>
            <th>メール送信先</th>
        </tr>
        @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>
                    <a class="customer-users__sender-select-link" href="{{ route('user.index', ['user_id' => Auth::id(), 'sender' => $customer->id]) }}">選択</a>
                </td>
            </tr>
        @endforeach
    </table>
    <div class="customer-users__pagination">
        {{ $customers->onEachSide(1)->links() }}
    </div>
</div>
@endsection