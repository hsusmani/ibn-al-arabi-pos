<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Carbon;

class Dashboard extends Component
{
    public function render()
    {


        $totalSales = Order::whereDate('created_at', Carbon::today())->get();

        return view('livewire.dashboard', compact('totalSales'));
    }
}
