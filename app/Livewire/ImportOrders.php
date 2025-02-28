<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Imports\OrdersImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Location;
use App\Models\Order;

class ImportOrders extends Component
{
    use WithFileUploads;

    public $items;

    #[validate('required|file|mimes:xlsx,csv')]
    public $file;

    public function updatedFile() {

        $validated = $this->validate();

        $import = new OrdersImport;
        Excel::import($import, $this->file);

        $this->items = $import->orders;
    }

    public function processImport() {


        foreach($this->items as $row) {
            $locations = Location::all()->toArray();
            $locationId;
            foreach($locations as $location) {
                if(in_array(auth()->user()->id, $location['users'])){
                    $locationId = $location['id'];
                };
            }

            Order::create([
                'created_at' => $row['date'],
                'updated_at' => $row['date'],
                'items' => $row['items'],
                'customer_name' => $row['customer_name'],
                'customer_phone' => $row['customer_phone'],
                'user_id' => auth()->user()->id,
                'location_id' => $locationId,
            ]);
        }
        return redirect()->route('orders')->with('message', 'Succesfully Imported Orders');
    }
    public function render()
    {
        return view('livewire.import-orders');
    }
}
