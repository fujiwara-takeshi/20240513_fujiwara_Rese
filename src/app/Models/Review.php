<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'evaluation',
        'comment',
        'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getS3Url()
    {
        return Storage::disk('s3')->temporaryUrl($this->image_path, now()->addMinutes(5));
    }

}
