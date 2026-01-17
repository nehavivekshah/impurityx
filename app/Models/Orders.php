<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'buyer_id',
        'quantity',
        'delivery_date',
        'delivery_location',
        'specific_requirements',
        'attachments',
        'status',
        'seller_status',
        'auction_end',
    ];
}
