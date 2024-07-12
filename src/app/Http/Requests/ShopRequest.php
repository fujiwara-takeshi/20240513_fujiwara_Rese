<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shop_name' => ['required', 'string', 'max:50'],
            'area_id' =>['required'],
            'genre_id' => ['required'],
            'detail' => ['required', 'string', 'max:255'],
            'image' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'shop_name.required' => '店舗名を入力してください',
            'shop_name.string' => '店舗名を文字列で入力してください',
            'shop_name.max' => '店舗名を50文字以下で入力してください',
            'area_id.required' => 'エリアを選択してください',
            'genre_id.required' => 'ジャンルを選択してください',
            'detail.required' => '店舗詳細を入力してください',
            'detail.string' => '店舗詳細を文字列で入力してください',
            'detail.max' => '店舗詳細を255文字以下で入力してください',
            'image.required' => '画像ファイルを選択してください'
        ];
    }
}
