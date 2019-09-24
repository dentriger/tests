<?php


namespace App;


class StudentUser extends User
{
    public function __construct(array $attributes = [])
    {
        $this->fillable[] = 'group';
        parent::__construct($attributes);
    }
}