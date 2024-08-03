<!DOCTYPE html>
<html>
<body>
<p>{{ $reservation->user->name }} 様</p>
<p>飲食店予約サービスReseより、本日のご予約についてご連絡いたします。</p>

<p>============================</p>
<p>ご予約情報</P>
<p>============================</p>

<p>店名：{{ $reservation->shop->name }}</p>

<p>予約名：{{ $reservation->user->name }} 様</p>

<p>予約日：{{ $reservation->datetime->toDateString() }}</p>

<p>予約時間：{{ $reservation->datetime->toTimeString('minute') }}</p>

<p>予約人数：{{ $reservation->number }}名</p>

@if($reservation->course_id === null)
<p>予約内容：席のみ予約</p>
@else
<p>予約内容：{{ $reservation->course->amount }}円コース</p>
@endif

<p>--------------------------------------------------</p>

<p>ご来店の際に、本メールと下記のQRコードをご提示ください。</P>
<img src="{{ $message->embedData($qr_code, 'reservation.png') }}" alt="QR CODE">

<p>ご来店お待ちしております。</p>
</body>
</html>
