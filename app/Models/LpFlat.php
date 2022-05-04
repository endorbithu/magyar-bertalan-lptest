<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpFlat extends Model
{

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label',
        'composers',
    ];


    protected $casts = [
        'published_on' => 'datetime',
    ];

}
