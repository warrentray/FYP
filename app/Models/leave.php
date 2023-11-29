<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class leave extends Model
{
    protected $table = 'leave';
    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = [
        'id',
        'leave_type',
        'totalNumber',
     ];
     public function staffLeaves()
    {
        return $this->hasMany(Staff_Leave::class, 'leaveType', 'leaveType');
    }
}
