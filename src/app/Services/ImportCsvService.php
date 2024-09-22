<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;

class ImportCsvService
{
    protected $csv_array = [];
    protected $tmp_file_path_array = [];

    public function getCsvArray($request)
    {
        $this->uploadCsvToArray($request);
        return $this->csv_array;
    }

    public function getTmpFilePathArray()
    {
        return $this->tmp_file_path_array;
    }

    private function downloadImage($image_url)
    {
        $response = Http::get($image_url);

        if ($response->successful()) {
            $tmp_file_path = storage_path('app/tmp' . uniqid() . '.tmp');
            file_put_contents($tmp_file_path, $response->body());
            $uploaded_file = new UploadedFile($tmp_file_path, basename($tmp_file_path), $response->header('Content-Type'), null, true);
            $this->tmp_file_path_array[] = $tmp_file_path;
            return $uploaded_file;
        } else {
            return null;
        }
    }

    private function uploadCsvToArray($request)
    {
        $file = $request->file('csv');
        $csv = new \SplFileObject($file->getRealPath());
        $csv->setFlags(
            \SplFileObject::READ_CSV |
            \SplFileObject::READ_AHEAD |
            \SplFileObject::SKIP_EMPTY |
            \SplFileObject::DROP_NEW_LINE
        );

        foreach($csv as $record) {
            switch($record[1]) {
                case '東京都':
                    $record[1] = 1;
                    break;
                case '大阪府':
                    $record[1] = 2;
                    break;
                case '福岡県':
                    $record[1] = 3;
                    break;
                default:
                    $record[1] = 'その他エリア';
            }
            switch($record[2]) {
                case '寿司':
                    $record[2] = 1;
                    break;
                case '焼肉':
                    $record[2] = 2;
                    break;
                case '居酒屋':
                    $record[2] = 3;
                    break;
                case 'イタリアン':
                    $record[2] = 4;
                    break;
                case 'ラーメン':
                    $record[2] = 5;
                    break;
                default:
                    $record[2] = 'その他ジャンル';
            }

            $uploaded_file = $this->downloadImage($record[4]);

            $this->csv_array[] = [
                'name' => $record[0],
                'area_id' => $record[1],
                'genre_id' => $record[2],
                'detail' => $record[3],
                'image' => $uploaded_file
            ];
        }
    }

    public function validationRules()
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'area_id' => ['required', 'integer', 'between:1,3'],
            'genre_id' => ['required', 'integer', 'between:1,5'],
            'detail' => ['required', 'string', 'max:400'],
            'image' => ['required', 'image', 'mimes:jpeg,png']
        ];
    }

    public function validationMessages()
    {
        return [
            'name.required' => '店舗名は必須です',
            'name.string' => '店舗名は文字列で入力してください',
            'name.max' => '店舗名は50文字以下で入力してください',
            'area_id.required' => 'エリア名は必須です',
            'area_id.integer' => 'エリア名には「東京都」「大阪府」「福岡県」のいずれかを入力してください',
            'area_id.between' => 'エリア名には「東京都」「大阪府」「福岡県」のいずれかを入力してください',
            'genre_id.required' => 'ジャンル名は必須です',
            'genre_id.integer' => 'ジャンル名には「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを入力してください',
            'genre_id.between' => 'ジャンル名には「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを入力してください',
            'detail.required' => '店舗詳細は必須です',
            'detail.string' => '店舗詳細は文字列で入力してください',
            'detail.max' => '店舗詳細は400文字以下で入力してください',
            'image.required' => '画像がのファイルリンクが貼り付けされていないか、画像の取得に失敗しました',
            'image.image' => '画像形式のファイルリンクを貼り付けしてください',
            'image.mimes' => '画像はjpeg形式かpng形式のファイルリンクを貼り付けしてください'
        ];
    }

}