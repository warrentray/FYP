<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class training extends Model
{
    use HasFactory;

    protected $table = 'training';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'training_name',
        'description',
        'start_date',
        'end_date',
        'status',
        'location',
     ];
     public function user()
     {
         return $this->belongsTo(user::class, 'user_id', 'id');
     }
}
