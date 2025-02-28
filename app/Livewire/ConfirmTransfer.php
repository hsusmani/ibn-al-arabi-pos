<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Stock;
use App\Models\Location;
use App\Models\StockLog;

class ConfirmTransfer extends Component
{

    public $productId;
    public $stockId;
    public $locationId;

    public $product;
    public $stock;
    public $expected_qnty;

    #[validate('required|integer|gte:1|lte:expected_qnty')]
    public $confirm_qnty;

    public function mount($stockId, $productId) {
        $this->stock = Stock::where('id', $stockId)->get();
        $this->expected_qnty = $this->stock->first()->expected_qnty;

        // productId for returning to previous view
    }

    public function confirm() {
        $validated = $this->validate();

        // find if there is previous stock at this location
        $this->locationId = Location::whereRelation('stocks', 'stock_id', $this->stock->first()->id)->pluck('id')->first();

        $stockExists = Stock::whereNot('id', $this->stockId)->where('is_confirmed', true)->whereRelation('location', 'location_id', $this->locationId)->whereRelation('product', 'product_id', $this->productId)->exists();

        if($stockExists == false) {
            $stock = Stock::where('id', $this->stockId)->get();
            Stock::where('id', $this->stockId)->update([
                'available_qnty' => (int)$validated['confirm_qnty'],
                'is_confirmed' => true
            ]);

        } else {
            $stock = Stock::where('id', $this->stockId)->get();
            $existingStock = Stock::whereNot('id', $this->stockId)->where('is_confirmed', true)->whereRelation('location', 'location_id', $this->locationId)->whereRelation('product', 'product_id', $this->productId)->get();
            // dd($stock->first()->available_qnty);
            Stock::whereNot('id', $this->stockId)->where('is_confirmed', true)->whereRelation('location', 'location_id', $this->locationId)->whereRelation('product', 'product_id', $this->productId)->update([
                'available_qnty' => $existingStock->first()->available_qnty + (int)$validated['confirm_qnty'],
                'expected_qnty' => $existingStock->first()->expected_qnty + $this->expected_qnty,
            ]);
            Stock::where('id', $this->stockId)->delete();
        }

        StockLog::create([
            'action' => 'Confirm Transfer',
            'from' => $this->locationId,
            'to' => $this->locationId,
            'user_id' => auth()->user()->id,
            'qnty' => $validated['confirm_qnty'],
        ]);

        session()->flash('message', 'Stock has been confirmed');
        return redirect()->route('stocks.details', ['stockId' => $this->stockId, 'productId' => $this->productId]);
    }
    public function render()
    {
        return view('livewire.confirm-transfer');
    }
}
