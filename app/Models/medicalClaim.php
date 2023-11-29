<?php

namespace App\Models;

 use Illuminate\Database\Eloquent\Model;

class medicalClaim extends Model
{
    protected $table = 'medical_claim';
    protected $primaryKey = 'id';
     protected $keyType = 'string';
     public $incrementing = false;  

    protected $fillable = [
        'id',
        'image',
        'claim_status',
        'amount',
        'reason',
        'user_id',
    ];
   
    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }   
}
