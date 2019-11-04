<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    protected $fillable = [
        'name', 'userId', 'results'
    ];

    public function user()
    {
        return $this->belongsTo('App\StudentUser', 'userId');
    }
}
