<div class="email">
    <h3 class="email__title">メールフォーム</h3>
    <div class="form__item-error">
        @error('sender')
            {{ $message }}
        @enderror
    </div>
    <form class="email__form" action="{{ route('mail.confirm')}}" method="post">
        @csrf
        <table class="email__form-table">
            <tr>
                <th class="email__form-table-header">
                    <label for="sender">To</label>
                </th>
                <td class="email__form-table-data">
                    @isset($sender)
                        <p class="email__form-sender-name">{{ $sender->name }}</p>
                        <a class="email__mypage-link" href="{{ route('user.index', ['user_id' => $user->id]) }}">×</a>
                        <input type="hidden" name="sender" value="{{ $sender->id }}">
                    @endisset
                    <a class="email__form-users-link" href="{{ route('users') }}">送信先選択</a>
                </td>
            </tr>
            <tr>
                <th class="email__form-table-header">
                    <label for="subject">件名</label>
                </th>
                <td class="email__form-table-data">
                    <input class="email__form-item-input" type="text" name="subject" id="subject" value="{{ old('subject') }}">
                </td>
            </tr>
            <tr>
                <th class="email__form-table-header">
                    <label for="message">本文</label>
                </th>
                <td class="email__form-table-data">
                    <textarea class="email__form-item-textarea" name="message" id="message" rows="10">{{ old('message') }}</textarea>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="email__form-table-data">
                    <button class="email__form-button-submit">確認</button>
                    <input class="email__form-button-reset" type="reset">
                </td>
            </tr>
        </table>
    </form>
</div>
