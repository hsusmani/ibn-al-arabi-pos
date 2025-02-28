<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Location;

class ImportProducts extends Component
{

    use WithFileUploads;

    public $items;

    #[validate('required|file|mimes:xlsx,csv')]
    public $file;

    public function updatedFile() {

        $validated = $this->validate();
        $this->items = (new ProductsImport)->toArray($this->file);
    }

    public function processImport() {

        foreach ($this->items[0] as $key => $row) {
            $locationId = Location::where('is_default', true)->pluck('id')->first();

            if($locationId == NULL) {
                return redirect()->route('locations.index')->with('message', 'Please add atleast 1 location first');
            }
            $sku = generateSKU();
            $productCreated = Product::create([
                'sku'  => $sku,
                'name' => $row['name'],
                'price' => [
                    'egp' => $row['price_egp'],
                    'usd' => $row['price_usd'],
                    'aed' => $row['price_aed'],
                    'mad' => $row['price_mad'],
                ],
                'cost' => $row['cost'],
                'barcode' => $row['isbn'],
                'weight' => $row['weight'],
                'cover' => $row['cover_type'],
                'edition' => $row['edition_no'],
                'author' => $row['author'],
                'dimensions' => $row['dimensions'],
                'pages' => $row['no_of_pages']
            ]);


            $stockCreated = Stock::create([
                'expected_qnty' => $row['qnty'], 'available_qnty' => $row['qnty'], 'is_confirmed' => 1,
            ]);
            $stockCreated->location()->attach([
                'location_id' => $locationId,
            ]);
            $productCreated->stocks()->attach([
                'stock_id' => $stockCreated->id,
            ]);

        }

        return redirect()->route('products.index')->with('message', 'Succesfully imported products');

    }
    public function render()
    {
        return view('livewire.import-products');
    }
}
