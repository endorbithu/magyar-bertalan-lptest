<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Lp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'label_id',
        'published_on',
    ];


    protected $casts = [
        'published_on' => 'datetime',
    ];

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function composers()
    {
        return $this->belongsToMany(Composer::class);
    }
}
