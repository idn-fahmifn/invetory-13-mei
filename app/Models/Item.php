<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'uuid', 'location_id', 'item_name', 'date_purchase', 'status', 'desc', 'image'
    ];


    protected $casts = [
        'date_purchase' => 'datetime'
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
