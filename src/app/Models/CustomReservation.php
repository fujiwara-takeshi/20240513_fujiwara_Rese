<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomReservation extends Pivot
{
    protected $casts = ['datetime' => 'datetime'];
}
