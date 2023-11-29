<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shift extends Model
{
    protected $table = 'shift';

    protected $primaryKey = 'id';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'ShiftType',
        'ShiftChangeStatus',
        'ChangeDate',
        'Reason',
    ];
    public function user()
    {
        return $this->belongsTo('App\models\user', 'user_id','id');

     }
}
