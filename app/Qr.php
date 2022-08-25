<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qr extends Model
{
    protected $fillable = [
        'serial_number',
        'fullname',
        'mobile',
        'type'
    ];
}
