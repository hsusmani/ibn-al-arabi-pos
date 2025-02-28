<form wire:submit='transfer'>
    <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">
        <div class="col-span-6">
            <label for="product" class="block font-medium text-sm/6">Product Name</label>
            <div class="mt-2">
                <input disabled type="text" id="name" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $stock->first()->product->first()->name }}">
            </div>
        </div>
        <div class="col-span-6">
            <label for="transfer_from" class="block font-medium text-sm/6">Transfer From</label>
            <div class="mt-2">
                <input disabled type="text" id="transfer_from" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $stock->first()->location->first()->name }}">
            </div>
        </div>


        <div class="col-span-6">
            <label for="qnty_available" class="block font-medium text-sm/6">Available Quantity</label>
            <div class="mt-2">
                <input disabled type="number" id="available_qnty" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $stock->first()->available_qnty }}">
            </div>
        </div>
        <div class="col-span-6">
            <label for="transfer_to" class="block font-medium text-sm/6">
                Transfer to
                <span class="text-red-800">*</span>
            </label>
            <div class="mt-2">
                <select wire:model='transfer_to' class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    <option value="">Select Location</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>

            </div>
            @error('transfer_to')
            <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-span-6">
            <label wire:model='qnty' for="qnty" class="block font-medium text-sm/6">
                Transfer quantity
                <span class="text-red-800">*</span>
            </label>
            <div class="mt-2">
                <input wire:model='qnty' type="number" id="qnty" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                @error('qnty') 
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-12">
            <div class="mt-2">
                <button class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
            </div>
        </div>
    </div>

</form>
