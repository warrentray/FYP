<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payslip extends Model
{
    use HasFactory;
    protected $table = 'payslip';
    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = ['id', 'date', 'total_amount', 'epf', 'SOCSO', 'EIS', 'leave_amount', 'medical_amount', 'netAmount','leave_id','user_id'];
    public function leave()
    {
        return $this->belongsTo(leave::class, 'leave_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
    
}
