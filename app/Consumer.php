<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consumer extends Model
{
    protected $fillable = ['name', 'age', 'city'];

    public static function getAvailableCities()
    {
        return ['Sofia', 'Plovdiv', 'Varna'];
    }
}
