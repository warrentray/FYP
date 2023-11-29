<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'tank_number',
        'tank_capability',
        'tank_type',
        'tank_quantity',
         
    ];     
    // Define relationships, if any (e.g., with Delivery and Station)
   

    public function station()
    {
        return $this->belongsTo(station::class, 'station_id', 'id');
    }
    public function stock()
    {
        return $this->belongsTo(stock::class, 'stock_id', 'id');
    }
}
