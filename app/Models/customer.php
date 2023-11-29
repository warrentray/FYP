<?php

namespace App\Models;

use App\Models\membership;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
 
 

class customer extends Model // Update the class name to Customer
{
    protected $table = 'customer';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'status',
        'referral_code',
        'password',
        'count_fail_login',
        'fail_login_time',
        'reward_points',
        'cust_points',
        'cust_rank',
        'chop_quantity',
        'qr_code',
        'token',
        'membership_id',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Membership():BelongsTo
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    } 

}
