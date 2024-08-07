<?php

namespace App\Http\Controllers;

use App\Mail\CreateMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Requests\MailRequest;

class MailController extends Controller
{
    public function confirm(MailRequest $request)
    {
        $sender = User::find($request->sender);
        $postarr = [
            'name' => $sender->name,
            'address' => $sender->email,
            'subject' => $request->subject,
            'message' => $request->message
        ];
        return view('mail.confirm', compact('postarr'));
    }

    public function send(Request $request)
    {
        $postarr = $request->all();
        $mailto = $postarr['address'];
        Mail::to($mailto)->send(new CreateMail($postarr));
        $request->session()->regenerateToken();

        return redirect()->route('user.index', ['user_id' => Auth::id()])->with('success', 'メールを送信しました');
    }
}
