<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Stock;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Product;
use App\Models\Location;

class CreateProduct extends Component
{
    use WithFileUploads;

    public $image;
    #[validate('required|min:3')]
    public $name;
    public $weight;
    #[validate('required|between:0,100000.00')]
    public $price_egp;
    public $price_aed;
    public $price_usd;
    public $price_mad;
    public $cost;
    public $barcode;
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

    public function mount() {

        // $this->imageSrc = '/storage/' . 'img_placeholder';
        // $product->weight == NULL ? $this->weight = 0 : $this->weight = $product->weight;
        // $this->name = $product->name;
        // $product->cost == NULL ? $this->cost = 0 : $this->cost = $product->cost;

        // $this->qnty = Stock::whereRelation('product', 'product_id', $product->first()->id)->pluck('available_qnty')->first();
        // foreach(json_decode($product->price) as $key => $value) {
        //     if($key == 'egp') $this->price_egp = $value;
        //     if($key == 'aed') $this->price_aed = $value;
        //     if($key == 'usd') $this->price_usd = $value;
        // }
        // $this->barcode = $product->barcode;
        // $this->sku = $product->sku;
        // $this->cover_type = $product->cover;
        // $this->edition = $product->edition;
        // $this->author = $product->author;
        // $this->dimensions = $product->dimensions;
        // $this->pages = $product->pages;
    }

    public function updatedImage() {
        $this->imageSrc = $this->image->store('photos/tmp', 'public');
        $this->imageSrc = $this->imageSrc;
    }

    public function store() {
        $this->locationId = Location::where('is_default', true)->pluck('id')->first();
        if($this->locationId == '') {
            session()->flash('message', 'No Locations found. Please Add Location first.');
            return redirect()->route('locations.index');
        }
        $this->cost = $this->cost ?? 0;
        $validated = $this->validate();
        if($this->image) $this->image = $this->image->store('photos', 'public');

        // generate SKU
        $this->sku = generateSKU();

        $productCreated = Product::create([
            'image' => $this->image = $this->image ?? NULL ,
            'name' => trim($validated['name']),
            'price' => [
                'egp' => $validated['price_egp'],
                'usd' => $this->price_usd = $this->price_usd ?? 0,
                'aed' => $this->price_aed = $this->price_aed ?? 0,
                'mad' => $this->price_mad = $this->price_mad ?? 0,
            ],
            'cost' => $this->cost = $this->cost ?? 0,
            'barcode' => $this->barcode = $this->barcode ?? NULL,
            'sku' => $this->sku,
            'weight' => $this->weight = $this->weight ?? 0,
            'cover' => $this->cover_type = $this->cover_type ?? 'hard',
            'edition' => $this->edition = $this->edition ?? 1,
            'author' => $this->author = $this->author ?? NULL,
            'dimensions' => $this->dimensions = $this->dimensions ?? NULL,
            'pages' => $this->pages = $this->pages ?? NULL
        ]);

        $this->locationId = Location::where('is_default', true)->pluck('id')->first();

        $stockCreated = Stock::create([
            'expected_qnty' => $validated['qnty'], 'available_qnty' => $validated['qnty'], 'is_confirmed' => 1,
        ]);
        $stockCreated->location()->attach([
            'location_id' => $this->locationId,
        ]);
        $productCreated->stocks()->attach([
            'stock_id' => $stockCreated->id,
        ]);

        session()->flash('message', 'Product Successfully Created.');
        return redirect()->route('products.index');

    }

    public function render()
    {
        return view('livewire.create-product');
    }
}
