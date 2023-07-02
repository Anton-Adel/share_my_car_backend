<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_location',
        'end_location',
        'start_time',
        'end_time',
        'start_date',
        'shared_seats',
        'user_id',
        'user_cluster',
    ];

}
