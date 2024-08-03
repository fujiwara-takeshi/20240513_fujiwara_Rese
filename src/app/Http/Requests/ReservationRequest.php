<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
        if ($this->isMethod('patch')) {
            return [
                'date' => 'required',
                'time' => 'required',
            ];
        }

        return [
            'date' => 'required',
            'time' => 'required',
            'number' => 'required',
            'course' => 'required',
            'payment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '予約日を選択してください',
            'time.required' => '予約時間を選択してください',
            'number.required' => '予約人数を選択してください',
            'course.required' => '予約内容を選択してください',
            'payment.required' => '支払い方法を選択してください',
        ];
    }
}
