<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    use HasFactory;
    protected $fillable = ['session_id', 'cycle_id', 'type', 'executed_at'];

    protected $casts = [
        'executed_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

}
