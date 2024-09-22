<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvImportFormRequest extends FormRequest
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
            'csv' => ['required', 'file', 'mimes:csv,txt', 'max:40960']
        ];
    }

    public function messages()
    {
        return [
            'csv.required' => 'CSVファイルを選択してください',
            'csv.file' => 'CSVファイルを選択してください',
            'csv.mimes' => 'CSV形式のファイルを選択してください',
            'csv.max' => '40KB以下のCSVファイルを選択してください'
        ];
    }
}
