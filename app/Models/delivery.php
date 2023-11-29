<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

 

class delivery extends Model
{
    protected $table = 'delivery';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'date',
        'time',
        'tank_number',
        'petrol_type',
        'quality',
        'status',
         
    ];
    
    // Define relationships, if any (e.g., with User)
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }   
    public function stock()
    {
        return $this->belongsTo(stock::class, 'stock_id', 'id');
    }
  
}
