<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;

class Product extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'json',
    ];

    public function stocks()
    {
        return $this->belongsToMany(Stock::class);
    }
}
