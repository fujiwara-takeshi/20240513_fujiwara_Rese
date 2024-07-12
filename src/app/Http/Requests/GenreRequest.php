<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
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
            'genre_name' => ['required', 'string', 'unique:genres', 'max:50']
        ];
    }

    public function messages()
    {
        return [
            'genre_name.required' => 'ジャンル名を入力してください',
            'genre_name.string' => 'ジャンル名を文字列で入力してください',
            'genre_name.unique' => '未登録のジャンル名を入力してください',
            'genre_name.max' => 'ジャンル名を50文字以下で入力してください'
        ];
    }
}
