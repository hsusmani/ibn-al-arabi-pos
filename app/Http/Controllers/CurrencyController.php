<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CurrencyController extends Controller
{
    public function change($name) {
        User::where('id', auth()->user()->id)->update([
            'preferred_currency' => $name,
        ]);

        session(['preferred_currency' => strtoupper($name)]);
        return redirect()->back();
    }
}
