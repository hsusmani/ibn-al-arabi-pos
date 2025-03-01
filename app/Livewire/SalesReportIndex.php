<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Location;
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

    public $location = 'All';
    public $locations;

    public $orderIds = [];

    public function updated() {

        $this->fromTimeStamp = Carbon::parse($this->from)->startOfDay();
        $this->toTimeStamp = Carbon::parse($this->to)->endOfDay();
        // $this->to ? $this->to = Carbon::parse($this->to)->endOfDay()->toDateString() : $this->from = Carbon::now()->endOfDay()->toDateString();

        // $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->pluck('items');

        $this->sales = [];
        $this->getSales();
        // $sales = Order::whereBetween('created_at', [$this->from, $this->to])->simplePaginate(10);
    }

    public function download() {
        // Blade::render('exports.salesReport', ['sales' => $this->sales]);
        return Excel::download(new OrdersExport($this->sales), 'salesreport.xlsx');
    }

    public function mount() {
        $this->fromTimeStamp = Carbon::now()->startOfDay();
        $this->toTimeStamp = Carbon::now()->endOfDay();
        $this->getSales();
    }

    public function getSales() {
        $this->from = $this->fromTimeStamp->toDateString();
        $this->to = $this->toTimeStamp->toDateString();

        $this->locations = Location::get();

        if($this->location == 'All') {
            $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->get();
        } else {
            $sales = Order::whereBetween('created_at', [$this->fromTimeStamp, $this->toTimeStamp])->where('location_id', $this->location)->get();
        }

        foreach($sales as $sale) {


            array_push($this->orderIds, [$sale->id]);

            foreach ($sale['items'] as $key => $item) {
                array_filter($this->sales, function($sale) use($item) {
                    dd($sale);
                    if($item['id'] == $sale['id']) dd(key($sale));
                });

                // if($saleKey) {
                //     dd($this->sales[$saleKey]['qnty']);
                //     $this->sales[$saleKey]['qnty'] = [
                //         'qnty' => $this->sales[$saleKey]['qnty'] + $item['qnty'],
                //         'total' => $this->sales[$saleKey]['total'] + $item['value']['discounted_price'],
                //     ];
                // } else {
                //     $this->sales[] = [
                //         'id' => $item['id'],
                //         'name' => $item['name'],
                //         'qnty' => $item['qnty'],
                //         'total' => $item['value']['discounted_price'],
                //     ];
                // }

            }
        }
        // dd($saleKey);

    }

    public function render()
    {
        return view('livewire.sales-report-index');
    }
}
