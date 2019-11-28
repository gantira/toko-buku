<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return ($value == null ? 'image/user.png' : $value);
    }
}
