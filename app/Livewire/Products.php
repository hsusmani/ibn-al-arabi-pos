<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\Product;
use App\Models\Location;
use App\Models\Stock;
use Livewire\WithFileUploads;

class Products extends Component
{
    use WithFileUploads;


    #[validate('required|min:3')]
    public $name;
    #[validate('integer')]
    public $cost = 0;
    #[validate('required|between:0,100000.00')]
    public $price_egp;
    public $price_usd;
    public $price_aed;
    public $sku;
    public $product_type;
    public $cover_type = 'hard-cover';
    public $barcode;
    public $weight = 0;
    public $edition = 1;
    public $author;
    public $dimensions;
    public $pages;

    public $locationId;

    #[validate('required|integer|min:1')]
    public $qnty;

    public $imagePath;

    public $update;

    public $product;


    #[validate('required')]
    public $image;


    public function updatedImage() {
        $this->imagePath = $this->image->store('photos', 'public');
    }
    public function store() {
        $this->locationId = Location::where('is_default', true)->pluck('id')->first();
        if($this->locationId == '') {
            session()->flash('message', 'No Locations found. Please Add Location first.');
            return redirect()->route('locations.index');
        }

        $validated = $this->validate();
        if($this->update == false) {
            $this->cost == '' ? $this->cost = NULL : $this->cost = $validated['cost'];
            if(empty(Product::count())) {
                $this->sku = 1001;
            } else {
                $this->sku = (int)Product::latest()->pluck('sku')->first() + 1;
            }



            $productCreated = Product::create([
                'image' => $this->imagePath,
                'name' => $validated['name'],
                'price' => json_encode([
                    'egp' => $validated['price_egp'],
                    'usd' => $this->price_usd ? $this->price_usd : 0,
                    'aed' => $this->price_aed ? $this->price_aed : 0,
                ]),
                'cost' => $this->cost,
                'barcode' => $this->barcode,
                'sku' => $this->sku,
                'weight' => $this->weight,
                'cover' => $this->cover_type,
                'edition' => $this->edition,
                'author' => $this->author,
                'dimensions' => $this->dimensions,
                'pages' => $this->pages
            ]);
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
        } else {
            sleep(2);
            $this->imagePath == NULL
            ? $this->imagePath = Product::where('id', $this->product->id)->pluck('image')->first()
            : $this->imagePath = $this->imagePath;
            Product::where('id', $this->product->id)->update([
                'image' => $this->imagePath,
                'name' => $validated['name'],
                'price' => [
                    'egp' => $validated['price_egp'],
                    'usd' => $this->price_usd ? $this->price_usd : 0,
                    'aed' => $this->price_aed ? $this->price_aed : 0,
                ],
                'cost' => $this->cost,
                'barcode' => $this->barcode,
                'sku' => $this->sku,
                'weight' => $this->weight,
                'cover' => $this->cover_type,
                'edition' => $this->edition,
                'author' => $this->author,
                'dimensions' => $this->dimensions,
                'pages' => $this->pages
            ]);
            $this->locationId = Location::where('is_default', true)->pluck('id')->first();
            Stock::where('is_confirmed', 1)->whereRelation('product', 'product_id', $this->product->id)->whereRelation('location', 'location_id', $this->locationId)->update([
                'expected_qnty' => $this->qnty,
                'available_qnty' => $this->qnty,
            ]);

            session()->flash('message', 'Product Updated Successfully.');
        }

            return redirect()->route('products.index');
    }

    public function mount($product = null) {
        if($product) {
            $this->update = true;
            $product->cost == NULL ? $this->cost = 0 : $this->cost = $product->cost;
            $product->weight == NULL ? $this->weight = 0 : $this->weight = $product->weight;
            $this->name = $product->name;

            $this->qnty = Stock::whereRelation('product', 'product_id', $product->first()->id)->pluck('available_qnty')->first();
            foreach(json_decode($product->price) as $key => $value) {
                if($key == 'egp') $this->price_egp = $value;
                if($key == 'aed') $this->price_aed = $value;
                if($key == 'usd') $this->price_usd = $value;
            }
            $this->barcode = $product->barcode;
            $this->sku = $product->sku;
            $this->cover_type = $product->cover;
            $this->edition = $product->edition;
            $this->author = $product->author;
            $this->dimensions = $product->dimensions;
            $this->pages = $product->pages;

        }
    }
    public function render()
    {
        return view('livewire.products');
    }
}
