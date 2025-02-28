<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Location;

class Log extends Model
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
    public function location() {
        return $this->belongsTo(Location::class);
    }
}
