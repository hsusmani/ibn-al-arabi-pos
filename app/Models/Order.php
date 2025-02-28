<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;

class Order extends Model
{
    protected $fillable = [
        'items',
        'prices',
        'user_id',
        'location_id',
        'customer_name',
        'customer_phone',
        'payment_method',
        'discount_note',
        'type',
        'refunded',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'items' => 'json',
        'prices' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
