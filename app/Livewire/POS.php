<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Location;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;


use Illuminate\Support\Facades\Storage;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Spatie\Browsershot\Browsershot;



class POS extends Component
{


    public $locations;
    public $products;
    public $stocks;

    // items available
    public $items = [];
    public $item;

    public $message;

    public $checkOutForm = 0;

    #[validate('required')]
    public $location;
    // items in cart
    #[validate('required')]
    public $cartItems = [];
    #[validate('required|min:1')]
    public $total = 0;
    #[validate('required|min:0|max:100')]
    public $discount = 0;

    public $customer;
    public $phone;
    public $payment = 'cash';
    public $discountNote;

    public $checkOutValidated;
    public $search = '';
    public $calculate;
    public $calculateAmounts;
    public $stocksInfo = [];
    public $currency;
    public $minMaxDiscount;
    public bool $orderHasDiscount = false;


    // mount
    public function mount() {



        $this->currency = strtolower(session('preferred_currency'));
        $this->locations = Location::get()->toArray();
        $location = '';

        if(session('location')) {
            $this->location = session('location');
        } else {
            array_filter($this->locations, function($location) {
                foreach ($location['users'] as $userId) {
                    if($userId == auth()->user()->id) {
                        $location = Location::query()->whereJsonContains('users', $userId)->first();
                        $this->location = $location->id;
                    }
                }
            });
        }


        if($this->location != NULL) {
            $this->stocks = Stock::with(['product', 'location'])->whereRelation('location', 'location_id', $this->location)->where('is_confirmed', 1)->get()->toArray();

            foreach($this->stocks as $key => $stock) {
                $this->items[] = [
                    'visible' =>  1,
                    'id' =>  $stock['product'][0]['id'],
                    'sku' =>  $stock['product'][0]['sku'],
                    'barcode' =>  $stock['product'][0]['barcode'],
                    'image' =>  $stock['product'][0]['image'],
                    'name' =>  $stock['product'][0]['name'],
                    'price_egp' =>  $stock['product'][0]['price']['egp'],
                    'price_usd' =>  $stock['product'][0]['price']['usd'],
                    'price_aed' =>  $stock['product'][0]['price']['aed'],
                    'price_mad' =>  $stock['product'][0]['price']['mad'],
                    'available_qnty' =>  $stock['available_qnty'],
                    'inCart' =>  0,
                ];
            }
            $this->stocksInfo = Stock::with(['product', 'location'])->where('is_confirmed', 1)->get()->toArray();
        }



        // if(!(auth()->user()->hasRole('Super') || auth()->user()->hasRole('Admin'))) {
        //     $this->locations = Location::where('id', (int)$this->location);
        // }


    }


    public function updatedSearch() {
        foreach($this->items as $key => $item) {

            if(str_contains(strtolower($item['sku']), strtolower($this->search)) ||
            str_contains(strtolower($item['name']), strtolower($this->search)) ||
            str_contains(strtolower($item['barcode']), strtolower($this->search))) {
                $this->items[$key]['visible'] = 1;
            } else {
                $this->items[$key]['visible'] = 0;
            }
        }
    }

    public function calculate($index = NULL, $single) {

        foreach($this->cartItems as $key => $cartItem) {
            if($this->cartItems[$key]['discount'] > 100) $this->cartItems[$key]['discount'] = 100;
            if($this->cartItems[$key]['discount'] < 0) $this->cartItems[$key]['discount'] = 0;
        }

        if(!$this->discount == 0) {
            if($this->discount > 100) $this->discount = 100;
            if($this->discount < 0) $this->discount = 0;
        }


        if($single == false) {
            foreach($this->cartItems as $key => $item) {
                $this->cartItems[$key]['discount'] = (int)$this->discount;
                $this->cartItems[$key]['subTotal'] = ($this->cartItems[$key]['price_'.$this->currency] - ($this->cartItems[$key]['discount']*$this->cartItems[$key]['price_'.$this->currency] / 100)) * $this->cartItems[$key]['qnty'];
            }
        } else {
            if(empty($this->cartItems)) {
                $this->total = 0;
                $this->discount = 0;
            } else {
                $this->cartItems[$index]['subTotal'] = ($this->cartItems[$index]['price_'.$this->currency] - ($this->cartItems[$index]['discount']*$this->cartItems[$index]['price_'.$this->currency] / 100)) * $this->cartItems[$index]['qnty'];
            }
        }

        $this->total = 0;

        foreach($this->cartItems as $key => $cartItem) {
            $this->total +=  (float)$cartItem['subTotal'];
        }

        //     $this->cartItems[$key]['subTotal'] = ($this->cartItems[$key]['price_'.$this->currency] - ($this->cartItems[(int)key($this->item)]['discount']*(int)$this->cartItems[(int)key($this->item)]['price_'.$this->currency] / 100)) * $this->cartItems[(int)key($this->item)]['qnty'];

        //     $this->total = (float)$this->total + (float)$cartItem['subTotal'];
        //     $this->gTotal = (float)$this->total - (((float)$this->total * (int)$this->discount) / 100);
        // }


    }

    public function updatedDiscount() {
        $this->calculate(NULL, false);
    }


    public function singleDiscount($index, $value) {
        $this->cartItems[$index]['discount'] = (int)$value;
        $this->calculate($index, true);
    }

    public function updatedLocation() {
        $this->search = '';
        $this->cartItems = [];
        $this->items = [];
        $this->total = 0;
        $this->discount = 0;

        $this->stocksInfo = [];

        session(['location' => (int)$this->location]);

        $this->stocks = Stock::with(['product', 'location'])->whereRelation('location', 'location_id', (int)$this->location)->get()->toArray();
        foreach($this->stocks as $stock) {
            $this->items[] = [
                'visible' =>  1,
                'id' =>  $stock['product'][0]['id'],
                'sku' =>  $stock['product'][0]['sku'],
                'barcode' =>  $stock['product'][0]['barcode'],
                'image' =>  $stock['product'][0]['image'],
                'name' =>  $stock['product'][0]['name'],
                'price_egp' => $stock['product'][0]['price']['egp'],
                'price_usd' => $stock['product'][0]['price']['usd'],
                'price_aed' => $stock['product'][0]['price']['aed'],
                'price_mad' => $stock['product'][0]['price']['mad'],
                'available_qnty' =>  $stock['available_qnty'],
                'inCart' =>  0,
            ];
            $this->stocksInfo = Stock::with(['product', 'location'])->where('is_confirmed', 1)->get()->toArray();
        }

    }


    public function addToCart($index) {
        // if stock is available
        // dd($this->items[$index]['price_'.strtolower(session('preferred_currency'))] != NULL);
        if($this->items[$index]['available_qnty'] > 0 && $this->items[$index]['price_'.strtolower(session('preferred_currency'))] != NULL) {
            // if in cart
            $this->item = array_filter($this->cartItems, function($cartItem) use($index) {
                if($cartItem['sku'] == $this->items[$index]['sku']) return $cartItem;
            });


            // if in the cart | change available qnty and qnty
            if($this->item) {
                $this->items[$index]['available_qnty']--;
                $this->cartItems[(int)key($this->item)]['qnty']++;
                $this->cartItems[(int)key($this->item)]['available_qnty']--;
                // if((int)$this->cartItems[(int)key($this->item)]['discount'] > 100) {
                    //     $this->cartItems[(int)key($this->item)]['discount'] = 100;
                    // } elseif((int)$this->cartItems[(int)key($this->item)]['discount'] < 0) {
                        //     $this->cartItems[(int)key($this->item)]['discount'] = 0;
                        // }


                // $this->cartItems[(int)key($this->item)]['subTotal'] = ((int)$this->cartItems[(int)key($this->item)]['price_'.$this->currency] - ($this->cartItems[(int)key($this->item)]['discount']*(int)$this->cartItems[(int)key($this->item)]['price_'.$this->currency] / 100)) * $this->cartItems[(int)key($this->item)]['qnty'];

            } else {
                // else add in the cart
                $this->items[$index]['available_qnty']--;
                $this->items[$index]['inCart'] = 1;

                $this->cartItems[] = [
                    'id' =>  $this->items[$index]['id'],
                    'sku' =>  $this->items[$index]['sku'],
                    'name' =>  $this->items[$index]['name'],
                    'price_egp' =>  $this->items[$index]['price_egp'],
                    'price_usd' =>  $this->items[$index]['price_usd'],
                    'price_aed' =>  $this->items[$index]['price_aed'],
                    'price_mad' =>  $this->items[$index]['price_mad'],
                    'discount' =>  0,
                    'available_qnty' =>  $this->items[$index]['available_qnty'],
                    'qnty' =>  1,
                    'subTotal' =>  $this->items[$index]['price_'.$this->currency],
                ];


            }
            $cartItem = '';
        $cartItem = array_filter($this->cartItems, function($cartItem) use($index) {
            if($cartItem['sku'] == $this->items[$index]['sku']) return $cartItem;
        });

        $this->calculate(key($cartItem), true);
            // if no stock of the item, show a message and do nothing
        }else {
            // show message saying no available
        }


        // dd($this->item);
    }

    public function plus($index) {
        // get the item in available items
        $this->item = array_filter($this->items, function($item) use($index) {
            if($item['sku'] == $this->cartItems[$index]['sku']) return $item;
        });
        if($this->items[(int)key($this->item)]['available_qnty'] != 0) {
            $this->cartItems[$index]['qnty']++;
            // calculate
            $this->items[(int)key($this->item)]['available_qnty']--;
            $this->cartItems[$index]['available_qnty']--;
        } else {
            // show message with no qnty
        }
        $this->calculate($index, true);
    }
    public function minus($index) {
        // get the item
        $this->item = array_filter($this->items, function($item) use($index) {
            if($item['sku'] == $this->cartItems[$index]['sku']) return $item;
        });
        if($this->cartItems[$index]['qnty'] > 1) {
            $this->cartItems[$index]['qnty']--;
            // calculate
            $this->items[(int)key($this->item)]['available_qnty']++;
            $this->cartItems[$index]['available_qnty']++;
        } else {
            // remove item from cart and calculate
            unset($this->cartItems[$index]);
            $this->items[(int)key($this->item)]['available_qnty']++;
            $this->cartItems = array_values($this->cartItems);
        }
        $this->calculate(count($this->cartItems) - 1, true);
    }

    public function openCheckoutForm() {
        $this->orderHasDiscount = false;
        // dd($this->cartItems);
        foreach($this->cartItems as $item) {
            if($item['discount'] > 0 || $this->discount > 0) $this->orderHasDiscount = true;
        }

        $this->checkOutValidated = $this->validate();
        $this->checkOutForm = 1;
    }

    public function closeCheckoutForm() {
        $this->checkOutForm = 0;
    }

    public function checkout($receipt) {
        $discountValidated = $this->validate([
            'orderHasDiscount' => 'required',
            'customer' => 'required_if:orderHasDiscount,=,true',
            'phone' => 'required_if:orderHasDiscount,=,true',
            'payment' => 'required',
            'discountNote' => 'required_if:orderHasDiscount,=,true',
        ]);
        $orderedItems = [];

        foreach($this->checkOutValidated['cartItems'] as $item) {
            $orderedItems[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'qnty' => $item['qnty'],
                'value' => [
                    'discount' => $item['discount'],
                    'original_price' => [
                        'egp' => (float)$item['price_egp'] * (int)$item['qnty'],
                        'usd' => (float)$item['price_usd'] * (int)$item['qnty'],
                        'aed' => (float)$item['price_aed'] * (int)$item['qnty'],
                        'mad' => (float)$item['price_mad'] * (int)$item['qnty'],
                    ],
                    'discounted_price' => [
                        'egp' => ($item['price_egp'] - ((float)$item['discount'] * (float)$item['price_egp'] / 100)) * (int)$item['qnty'],
                        'usd' => ($item['price_usd'] - ((float)$item['discount'] * (float)$item['price_usd'] / 100)) * (int)$item['qnty'],
                        'aed' => ($item['price_aed'] - ((float)$item['discount'] * (float)$item['price_aed'] / 100)) * (int)$item['qnty'],
                        'mad' => ($item['price_mad'] - ((float)$item['discount'] * (float)$item['price_aed'] / 100)) * (int)$item['qnty'],
                    ],
                ]
            ];
        }

        $orderCreated = Order::create([
            'items' => $orderedItems,
            'user_id' => auth()->user()->id,
            'location_id' => $this->location,
            'customer_name' => $discountValidated['customer'],
            'customer_phone' => $discountValidated['phone'],
            'discount_note' => $discountValidated['discountNote'],
            'payment_method' => $discountValidated['payment'],
            'type' => 'sale',
            'refunded' => 0,
        ]);
        if($orderCreated) {
            foreach ($orderedItems as $item) {
                Stock::whereRelation('product', 'product_id', (int)$item['id'])->whereRelation('location', 'location_id', $this->location)->where('is_confirmed', true)->decrement('available_qnty', (int)$item['qnty']);
                Stock::whereRelation('product', 'product_id', (int)$item['id'])->whereRelation('location', 'location_id', $this->location)->where('is_confirmed', true)->decrement('expected_qnty', (int)$item['qnty']);
            }
        }

        $order = Order::where('id', $orderCreated->id)->get();

        $orderDetails = [
            'id' => $order->first()->id,
            'date' => $order->first()->created_at,
            'payment_method' => $order->first()->payment_method,
            'customer_name' => $order->first()->customer_name,
            'customer_phone' => $order->first()->customer_phone,
            'discount_note' => $order->first()->discount_note,
            'type' => $order->first()->type,
            'refunded' => 0,
        ];

        foreach($order->first()->items as $key => $item) {
            $orderDetails['items'][$key] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'qnty' => $item['qnty'],
                'value' => $item['value'],
            ];
        }

        if($receipt == 1) {
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
        return redirect()->route('pos')->with('message', 'Successfully Processed Order');
    }



    public function render()
    {
        return view('livewire.p-o-s');
    }
}
