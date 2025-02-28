<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// excel

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use Maatwebsite\Excel\Concerns\Exportable;


class PosController extends Controller
{
    use Exportable;

    public function index() {
        return view('pos.index');
    }

}
