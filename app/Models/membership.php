<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membership extends Model
{
    protected $table = 'membership';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'rank_name',
        'required_points',
    ];
}
