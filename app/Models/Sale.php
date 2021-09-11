<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'package_id', 'marketing_id', 'paid_status', 'paid_img', 'paid_at', 'confirm_status'
    ];
}
