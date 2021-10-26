<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id', 'title', 'price', 'duration', 'status'
    ];
}
