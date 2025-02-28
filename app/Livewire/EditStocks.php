<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use App\Models\Location;
use App\Models\Product;
use App\Models\StockLog;
use Livewire\Attributes\Validate;

class EditStocks extends Component
{

    public $stock;
    public $stockId;
    public $productId;

    #[validate('required|integer')]
    public $expected_qnty;

    #[validate('required|integer|lte:expected_qnty|gte:0')]
    public $available_qnty;


    public function edit() {

        $validated = $this->validate();
        Stock::where('id', $this->stockId)->update([
            'available_qnty' => $validated['available_qnty'],
            'expected_qnty' => $validated['expected_qnty'],
        ]);

    StockLog::create([
        'action' => 'Edit',
        'from' => $this->stock->first()->location->first()->id,
        'to' => $this->stock->first()->location->first()->id,
        'user_id' => auth()->user()->id,
        'qnty' => $validated['available_qnty'],
    ]);

        session()->flash('message', 'Stock has been updated');
        return redirect()->route('stocks.details', ['stockId' => $this->stockId, 'productId' => $this->productId]);

    }
    public function mount($stockId, $productId) {
        $this->stock = Stock::where('id', $stockId)->whereRelation('product', 'product_id', $productId)->get();
        $this->stockId = $stockId;
        $this->$productId = $productId;

        $this->expected_qnty = $this->stock->first()->expected_qnty;
        $this->available_qnty = $this->stock->first()->available_qnty;

        // $this->locations = Location::whereNot('id', $this->stock->first()->location->first()->id)->get();
        // $this->available_qnty = $this->stock->first()->available_qnty;
        // $this->locationId = $this->stock->first()->location->first()->id;

        // // productId is for returning to previous view
        // $this->productId = $this->stock->first()->product->first()->id;

    }
    public function render()
    {
        return view('livewire.edit-stocks');
    }
}
