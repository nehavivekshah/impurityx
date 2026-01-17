<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermetas extends Model
{
    use HasFactory;
    
    protected $table = 'usermetas';
    
    protected $fillable = [
        'uid',
        'company',
        'trade',
        'panno',
        'vat',
        'regAddress',
        'comAddress',
        'city',
        'pincode',
        'state',
        'country',
        'status',
    ];
}
