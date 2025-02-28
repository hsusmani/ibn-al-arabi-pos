<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockLog;
use App\Models\Location;

class LogController extends Controller
{

    public function stockLogs() {

        $allLogs = StockLog::with(['user'])->get()->toArray();
        $logs = [];

        foreach($allLogs as $log) {
            $logs[] = [
                'from' => Location::where('id', $log['from'])->pluck('name')->first(),
                'to' => Location::where('id', $log['to'])->pluck('name')->first(),
                'qnty' => $log['qnty'],
                'user' => $log['user']['name'],
                'action' => $log['action'],
            ];

        }
        return view('stocks.logs', compact('logs'));
    }
}
