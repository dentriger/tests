<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTestsList extends Model
{
    protected $fillable = [
        'userId', 'teacherId', 'testId', 'status', 'assignDate'
    ];
}