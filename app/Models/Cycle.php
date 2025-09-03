<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    protected $fillable = [
        'session_id',
        'rhythm_type',
        'start_time',
        'number'
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
