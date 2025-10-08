<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable = ['start_time', 'end_time'];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    public function cycles()
    {
        return $this->hasMany(Cycle::class);
    }
}
