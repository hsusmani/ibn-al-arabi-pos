<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class OrdersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    protected $sales;

    function __construct($sales) {
           $this->sales = $sales;
    }

    public function view(): View
    {



        // dd($this->sales);
        // $orders = Order::pluck('items');
        // $sales = [];
        // foreach($orders as $order) {
        //     foreach($order as $item) {
        //         if($item['id']) {
        //             $sales[] = [
        //                 'name' => $item['name'],
        //                 'qnty' => $item['qnty'],
        //                 'total' => $item['qnty'] * pricePerCurrency($item['value']['discounted_price']),
        //             ];
        //         }
        //     }
        // }

        return view('exports.salesReport', [
            'sales' => $this->sales
        ]);

        return redirect('sales.index')->with('message', 'Downloaded Successfully');

    }
}
