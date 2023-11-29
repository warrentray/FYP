<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role',
        'gender',
        'count_fail_login',
        'fail_login_time',
        'shift_id',
        'salary_id',
        'station_id',
    ];
    public function shift()
    {
        return $this->belongsTo(shift::class, 'shift_id', 'id');
    }
    
    public function salary()
    {
        return $this->belongsTo(salary::class, 'salary_id', 'id');
    }
    
    public function station()
    {
        return $this->belongsTo(station::class, 'station_id', 'id');
    }
    
}
 
