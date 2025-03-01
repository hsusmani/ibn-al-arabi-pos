<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Product;
use App\Models\Location;

class EditProduct extends Component
{
    use WithFileUploads;

    public $image;
    #[validate('required|min:3')]
    public $name;
    public $cost;
    public $weight;
    #[validate('required|between:0,100000.00')]
    public $price_egp;
    public $price_aed;
    public $price_usd;
    public $price_mad;
    public $barcode;
    #[validate('required|integer')]
    public $sku;
    public $cover_type;
    public $edition;
    public $author;
    public $dimensions;
    public $pages;
    #[validate('required|integer|min:1')]
    public $qnty;

    public $imageSrc;
    public $locationId;
    public $product;

    public function mount($product) {
        $this->product = $product;

        foreach($product->price as $key => $value) {
            if($key == 'egp') $this->price_egp = $value;
            if($key == 'aed') $this->price_aed = $value;
            if($key == 'usd') $this->price_usd = $value;
            if($key == 'mad') $this->price_mad = $value;
        }

        // dd($this->product->id);
        $this->imageSrc = $product->image;
        $this->name = $product->name;
        $this->qnty = Stock::whereRelation('product', 'product_id', $this->product->id)->pluck('available_qnty')->first();
        $this->barcode = $product->barcode;
        $this->sku = $product->sku;
        $this->cover_type = $product->cover;
        $this->cost = $product->cost;
        $this->edition = $product->edition;
        $this->author = $product->author;
        $this->dimensions = $product->dimensions;
        $this->pages = $product->pages;
        $this->weight = $product->weight;

    }

    public function updatedImage() {
        $this->imageSrc = $this->image->store('photos/tmp', 'public');
    }

    public function store() {


        $validated = $this->validate();
        if($this->image == NULL) {
            $this->image = $this->imageSrc;
        } else {
            $this->image = $this->image->store('photos', 'public');
        }

        $productUpdated = Product::where('id', $this->product->id)->update([
            'image' => $this->image,
            'name' => $validated['name'],
            'price' => [
                'egp' => $validated['price_egp'],
                'usd' => $this->price_usd ? $this->price_usd : 0,
                'aed' => $this->price_aed ? $this->price_aed : 0,
                'mad' => $this->price_mad ? $this->price_mad : 0,
            ],
            'cost' => $this->cost ? $this->cost : 0,
            'barcode' => $this->barcode ? $this->barcode : NULL,
            'weight' => $this->weight ? $this->weight : 0,
            'cover' => $this->cover_type ? $this->cover_type : 'hard',
            'edition' => $this->edition ? $this->edition : 1,
            'author' => $this->author,
            'dimensions' => $this->dimensions,
            'pages' => $this->pages ? $this->pages : NULL
        ]);

        $this->locationId = Location::where('is_default', true)->pluck('id')->first();
        Stock::where('is_confirmed', 1)->whereRelation('product', 'product_id', $this->product->id)->whereRelation('location', 'location_id', $this->locationId)->update([
            'expected_qnty' => $validated['qnty'],
            'available_qnty' => $validated['qnty'],
        ]);

        session()->flash('message', 'Product Updated Successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.edit-product');
    }
}
