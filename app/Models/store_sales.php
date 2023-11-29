<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class store_sales extends Model
{ 
    protected $table = 'stock';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;

    // Define relationships, if any (e.g., with Delivery and Station)
    public function delivery()
    {
        return $this->belongsTo(delivery::class, 'delivery_id', 'id');
    }

    public function station()
    {
        return $this->belongsTo(Station::class, 'station_id', 'id');
    }
}
