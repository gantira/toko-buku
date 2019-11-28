<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return ($value == null ? 'image/book.png' : $value);
    }
}
