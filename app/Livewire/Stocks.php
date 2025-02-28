<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Location;
use App\Models\Stock;
use App\Models\StockLog;
use Livewire\Attributes\Validate;

class Stocks extends Component
{
    #[validate('required:integer|min:1')]
    public $product = '';
    #[validate('required:integer|min:1')]
    public $qnty = '';

    public $location;
    public $stock;
    public $products;

    public $stockId;
    public $productId;

    public function store() {
        $validated = $this->validate();
        Stock::where('id', $this->stock->pluck('id'))->increment('expected_qnty', $validated['qnty']);
        Stock::where('id', $this->stock->pluck('id'))->increment('available_qnty', $validated['qnty']);

        StockLog::create([
            'action' => 'Add',
            'from' => Location::where('is_default', 1)->pluck('id')->first(),
            'to' => Location::where('is_default', 1)->pluck('id')->first(),
            'user_id' => auth()->user()->id,
            'qnty' => $validated['qnty'],
        ]);

        session()->flash('message', 'Stock has been added successfully');
        return redirect()->route('stocks.details', ['productId' => $this->productId]);
    }

    public function updatedProduct($productId) {
        $this->product = Product::where('id', (int)$productId)->pluck('id')->first();
        $this->location = Location::where('is_default', true)->get();
        $this->stock = Stock::whereRelation('location', 'location_id', $this->location->first()->id)->whereRelation('product', 'product_id', $this->product)->get();
    }
    public function mount($stockId, $productId) {
        // get this stock details
        $this->stock = Stock::where('id', $stockId)->get();
        $this->products = Product::all();

        // productId is for returning to previous view only

        // $product = Product::where('id', $id)->get();
        // $location = $product->first()->stocks->first()->location->where('id', auth()->user()->id);
        // $stocks = Stock::whereRelation('location', 'location_id', $location->first()->id)->whereRelation('product', 'product_id', $product->first()->id)->get();

        $this->product = $this->stock->first()->product->first()->id;
    }

    public function render()
    {
        return view('livewire.stocks');
    }
}
