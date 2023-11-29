<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;
    protected $table = 'salary';
    protected $primaryKey = 'id';
     protected $keyType = 'string';
    protected $fillable = ['id', 'basic_salary', 'bonus_type', 'bonus_amount'];
     
 
}
