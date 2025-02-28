<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Location;
use App\Models\Product;
use Livewire\Attributes\Validate;
use App\Models\StockLog;

class Transfers extends Component
{

    public $stock;
    public $stockId;
    public $productId;
    public $locationId;

    public $locations;
    public $product;

    public $available_qnty;
    public $is_transferred;
    public $is_confirmed;

    #[validate('required')]
    public $transfer_to;
    #[validate('required|integer|gte:1|lte:available_qnty')]
    public $qnty;


    public function transfer() {
        $validated = $this->validate();
        $stockCreated = Stock::create([
            'expected_qnty' => $validated['qnty'],
            'is_transferred' => 1,
        ]);
        $stockCreated->location()->attach([
            'location_id' => $validated['transfer_to'],
        ]);
        $stockCreated->product()->attach([
            'product_id' => $this->productId,
        ]);
        // $stockCreated->attach()
        Stock::where('id', $this->stock->first()->id)->decrement('expected_qnty', $validated['qnty']);
        Stock::where('id', $this->stock->first()->id)->decrement('available_qnty', $validated['qnty']);

        StockLog::create([
            'action' => 'Transfer',
            'from' => $this->locationId,
            'to' => $validated['transfer_to'],
            'user_id' => auth()->user()->id,
            'qnty' => $validated['qnty'],
        ]);


        session()->flash('message', 'Stock has been transferred');
        return redirect()->route('stocks.details', ['stockId' => $this->stockId, 'productId' => $this->productId]);

    }
    public function mount($stockId, $productId) {
        $this->stock = Stock::where('id', $stockId)->get();
        $this->locations = Location::whereNot('id', $this->stock->first()->location->first()->id)->get();
        $this->available_qnty = $this->stock->first()->available_qnty;
        $this->locationId = $this->stock->first()->location->first()->id;

        // productId is for returning to previous view
        $this->productId = $this->stock->first()->product->first()->id;

    }
    public function render()
    {
        return view('livewire.transfers');
    }
}
