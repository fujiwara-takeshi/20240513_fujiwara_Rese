<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'evaluation' => ['required'],
            'comment' => ['max:400'],
            'image' => ['image', 'mimes:jpeg,png']
        ];
    }

    public function messages()
    {
        return [
            'evaluation.required' => '評価を選択してください',
            'comment.max' => 'コメントを400文字以下で入力してください',
            'image.image' => '画像形式のファイルをアップロードしてください',
            'image.mimes' => '画像はjpegかpng形式のファイルをアップロードしてください'
        ];
    }
}
