<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'status'
    ];

    public function packets()
    {
        return $this->hasMany(Packet::class);
    }

    public function sales()
    {
        return $this->hasManyThrough(Sale::class, Packet::class);
    }
}
