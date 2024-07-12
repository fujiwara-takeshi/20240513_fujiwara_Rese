<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'area_name' => ['required', 'string', 'unique:areas', 'max:50']
        ];
    }

    public function messages()
    {
        return [
            'area_name.required' => 'エリア名を入力してください',
            'area_name.string' => 'エリア名を文字列で入力してください',
            'area_name.unique' => '未登録のエリア名を入力してください',
            'area_name.max' => 'エリア名を50文字以下で入力してください'
        ];
    }
}
