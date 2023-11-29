<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff_leave extends Model
{
    protected $table = 'staff_leave';

    protected $fillable = [
        'id',
        'leaveType',
        'totalLeave',
        'leaveBal',
        'reason',
        'applyStartDate',
        'applyEndDate',
        'status',
        'leave_id',
        'user_id',
    ];

    public $incrementing = false; // To prevent auto-incrementing on the primary key

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id'); 

    }
    
    public function leave()
    {
        return $this->belongsTo(leave::class, 'leave_id');
    }

   
}
