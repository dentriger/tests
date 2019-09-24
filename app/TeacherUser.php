<?php


namespace App;


class TeacherUser extends User
{
    public function __construct(array $attributes = [])
    {
        $this->fillable[] = 'password';
        $this->hidden[] = 'password';
        parent::__construct($attributes);
    }
}