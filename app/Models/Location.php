<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use App\Models\Order;
use App\Models\User;

class Location extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'users' => 'json',
    ];
    public function stocks() {
        return $this->belongsToMany(Stock::class);
    }
    public function orders() {
        return $this->belongsToMany(Order::class);
    }
    public function users() {
        return $this->BelongsToMany(User::class);
    }
}
