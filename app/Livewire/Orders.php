<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Stock;
use Illuminate\Support\Facades\Storage;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Spatie\Browsershot\Browsershot;

class Orders extends Component
{

    public $formOpen = false;
    public $itemsDetail = [];
    public $orderDetails = [];

    public $refundItems = [];
    public $refundItemKeys = [];
    public $refundOrderDetails = [];

    public $itemsSelected = [];
    public $id;
    public $refundItemIds = [];

    public function viewOrder($id) {
        $this->id = $id;
        $this->formOpen = true;
        $order = Order::where('id', $this->id)->with('user')->get();

        $this->orderDetails = [
            'id' => $order->first()->id,
            'date' => $order->first()->created_at,
            'payment_method' => $order->first()->payment_method,
            'user' => $order->first()->user->name,
            'customer_name' => $order->first()->customer_name,
            'customer_phone' => $order->first()->customer_phone,
            'type' => $order->first()->type,
            'refunded' => $order->first()->refunded,
        ];

        foreach($order->first()->items as $key => $o) {
            $this->orderDetails['items'][$key] = [
                'id' => $o['id'],
                'name' => $o['name'],
                'qnty' => $o['qnty'],
                'value' => $o['value']
            ];
        }
    }

    public function refund($receipt) {

        $order = Order::where('id', $this->id)->get();

        if(empty($this->itemsSelected)) {
            foreach ($order->first()->items as $key => $item) {
                array_push($this->refundItemIds, $item['id']);
            }
        } else {
            foreach ($this->itemsSelected as $key => $id) {
                array_filter($order->first()->items, function($item) use($id) {
                    if($item['id'] == $id) array_push($this->refundItemIds, $item['id']);
                });
            }

        }



        $orderDetails = [
            'id' => $order->first()->id,
            'date' => $order->first()->created_at,
            'payment_method' => $order->first()->payment_method,
            'customer_name' => $order->first()->customer_name,
            'customer_phone' => $order->first()->customer_phone,
            'discount_note' => $order->first()->discount_note,
            'location_id' => $order->first()->location_id,
            'type' => 'refund',
            'refunded' => $order->first()->refunded,

        ];

        foreach($order->first()->items as $key => $item) {
            foreach($this->refundItemIds as $id) {
                if((int)$id == (int)$item['id']) {
                    $orderDetails['items'][$key] = [
                        'id' => $item['id'],
                        'name' => $item['name'],
                        'qnty' => $item['qnty'],
                        'value' => $item['value'],
                    ];
                }
            }
        }

        $orderCreated = Order::create([
            'items' => $orderDetails['items'],
            'user_id' => auth()->user()->id,
            'location_id' => $orderDetails['location_id'],
            'customer_name' => $orderDetails['customer_name'],
            'customer_phone' => $orderDetails['customer_phone'],
            'discount_note' => $orderDetails['discount_note'],
            'payment_method' => $orderDetails['payment_method'],
            'type' => 'refund',
            'refunded' => 1,
        ]);

        if($orderCreated) {
            $order = Order::where('id', $orderCreated->id)->get();
            $orderDetails = [
                'id' => $order->first()->id,
                'date' => $order->first()->created_at,
                'payment_method' => $order->first()->payment_method,
                'customer_name' => $order->first()->customer_name,
                'customer_phone' => $order->first()->customer_phone,
                'discount_note' => $order->first()->discount_note,
                'location_id' => $order->first()->location_id,
                'type' => $order->first()->type,
                'refunded' => $order->first()->refunded,
            ];

            foreach($order->first()->items as $key => $item) {
                foreach($this->refundItemIds as $id) {
                    if((int)$id == (int)$item['id']) {
                        $orderDetails['items'][$key] = [
                            'id' => $item['id'],
                            'name' => $item['name'],
                            'qnty' => $item['qnty'],
                            'value' => $item['value'],
                        ];
                    }
                }
            }
        }
        Order::where('id', $this->id)->update([
            'refunded' => 1,
        ]);


        foreach($this->refundItemIds as $key => $id) {
            foreach ($orderDetails['items'] as $loop => $item) {
                if($item['id'] == $id) {
                    Stock::where('is_confirmed', true)->whereRelation('location', 'location_id', (int)$orderDetails['location_id'])->whereRelation('product', 'product_id', (int)$id)->increment('expected_qnty', $item['qnty']);
                    Stock::where('is_confirmed', true)->whereRelation('location', 'location_id', (int)$orderDetails['location_id'])->whereRelation('product', 'product_id', (int)$id)->increment('available_qnty', $item['qnty']);
                };
            }
        }

        if($receipt == 1) {
            // dd('test');
            $html = view('printables.orderReceipt', compact('orderDetails'))->render();

            Browsershot::html($html)
            ->select('#receiptBody', 0)
            ->greyscale()
            ->save(storage_path("app/public/receipts/receipt.png"));

            $connector = new WindowsPrintConnector('EPR250UE');
            $profile = CapabilityProfile::load("default");

            $printer = new Printer($connector, $profile);


            $printImage = EscposImage::load(storage_path("app/public/receipts/receipt.png"), false);
            $printer -> bitImage($printImage);
            $printer -> feed(3);
            $printer -> cut();
            $printer -> close();

        }
        return redirect()->route('orders')->with('message', 'Successfully Processed Refund');
    }



    public function closeForm() {
        $this->formOpen = false;
        $this->itemsSelected = [];
    }

    public function mount() {

    }
    public function render()
    {
        if(isAdmin()) {
            $orders = Order::with('location', 'user')->get()->toArray();
        } else {
            $orders = Order::with('location', 'user')->where('user_id', auth()->user()->id)->get()->toArray();
        }

        return view('livewire.orders', compact('orders'));
    }
}
