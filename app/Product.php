<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function getImageAttribute($value)
    {
        return ($value == null ? 'image/book.png' : $value);
    }
}
