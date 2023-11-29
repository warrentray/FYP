<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petrol extends Model
{
    protected $table = 'petrol';
    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = ['id', 'petrol_name', 'petrol_type', 'price_per_liter','stock_id'];
   public function stock()
    {
        return $this->belongsTo(stock::class, 'stock_id', 'id');
    }
}
