<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class station extends Model
{
    use HasFactory;

    protected $table = 'station';

    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'address',
        'operationHours',
        'phoneNo',
        'status',
        'qr',
    ];
    public function user()
    {
        return $this->hasMany('App\models\user', 'station_id');

     }
}
 
