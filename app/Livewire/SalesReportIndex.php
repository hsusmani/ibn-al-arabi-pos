<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class SalesReportIndex extends Component
{

    public $to;
    public $from;
    public $fromTimeStamp;
    public $toTimeStamp;
    public $getSales;
    public $sales = [];

    public $orderIds = [];

    public function updated() {

        $this->fromTimeStamp = Carbon::parse($this->from)->startOfDay();
        $this->toTimeStamp = Carbon::parse($this->to)->endOfDay();
        // $this->to ? $this->to = Carbon::parse($this->to)->endOfDay()->toDateString() : $this->from = Carbon::now()->endOfDay()->toDateString();

        // $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->pluck('items');
        $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->get();

        $this->sales = [];
        $this->getSales($sales);
        // $sales = Order::whereBetween('created_at', [$this->from, $this->to])->simplePaginate(10);
    }

    public function getSales($sales) {

        foreach($sales as $sale) {

            array_push($this->orderIds, [$sale->id]);

            foreach ($sale['items'] as $key => $item) {
                $this->sales[] = [
                    'name' => $item['name'],
                    'name' => $item['name'],
                    'qnty' => $item['qnty'],
                    'total' => pricePerCurrency($item['value']['discounted_price']) * $item['qnty'],
                ];
            }
        }

    }

    public function download() {
        // Blade::render('exports.salesReport', ['sales' => $this->sales]);
        return Excel::download(new OrdersExport($this->sales), 'salesreport.xlsx');
    }

    public function mount() {
        $this->fromTimeStamp = Carbon::now()->yesterday();
        $this->from = $this->fromTimeStamp->toDateString();

        $this->toTimeStamp = Carbon::now();
        $this->to = $this->toTimeStamp->toDateString();

        $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->get();
        $this->getSales($sales);
    }
    public function render()
    {
        return view('livewire.sales-report-index');
    }
}
