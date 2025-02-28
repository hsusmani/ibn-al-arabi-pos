<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'from',
        'to',
        'qnty'
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }

}
