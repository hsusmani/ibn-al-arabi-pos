<form wire:submit='store'>
    <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">
        <div class="col-span-6">
            {{-- <div>Product Details:</div> --}}
            {{-- @dd($details->product->name) --}}
            @if($stock)
            <div class="grid items-center grid-cols-2">
                <div class="p-5"><img src="{{ $stock->first()->product->first()->image ? asset('storage').'/'.$stock->first()->product->first()->image : asset('storage').'/img_placeholder.jpg' }}"></div>
                <div class="flex flex-col ms-4">
                    <h1 class="text-lg">{{ $stock->first()->product->first()->name }}</h1>
                    <div class="flex flex-col mt-1 flex-inline">
                        <small class="text-red-700">Selling Price: {{ session('preferred_currency') }} {{ pricePerCurrency($stock->first()->product->first()->price) }}</small>
                        <small>Available Quantity: {{ $stock->first()->available_qnty }}</small>
                        <small>SKU: {{ $stock->first()->product->first()->sku }}</small>
                        <small>Barcode: {{ $stock->first()->product->first()->barcode }}</small>
                    </div>
                </div>
            </div>
            @else
            <small>Select the product to show the details</small>
            @endif
        </div>
        <div class="col-span-6">
            <div class="col-span-12 mt-4">
                <label for="product" class="block text-sm font-medium text-gray-700">
                    Product
                </label>
                <div>
                    <select name="product" id="product" wire:model.live='product' class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('product')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-12 mt-4">
                <label for="qnty" class="block text-sm font-medium text-gray-700">
                    Quantity
                </label>
                <div>
                    <input wire:model="qnty" type="number" id="qnty" placeholder="Quantity to be added" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('qnty')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-span-12 mt-4">
                <button type="submit" class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
            </div>
        </div>
    </div>
</form>
