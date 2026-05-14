<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'uuid', 'location_name', 'user_id', 'size', 'status', 'layout_image', 'desc'
    ];
}
