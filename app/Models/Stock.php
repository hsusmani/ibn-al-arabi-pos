<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Location;

class Stock extends Model
{
    protected $guarded = ['id'];

    public function product() {
        return $this->belongsToMany(Product::class);
    }

    public function location() {
        return $this->belongsToMany(Location::class);
    }
}
