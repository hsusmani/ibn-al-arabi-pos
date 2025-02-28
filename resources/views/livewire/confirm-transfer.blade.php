<form wire:submit='confirm'>
    <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">
        <div class="col-span-4">
            <label for="product" class="block font-medium text-sm/6">Product Name</label>
            <div class="mt-2">
                <input disabled type="text" id="name" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $stock->first()->product->first()->name }}">
            </div>
        </div>
        <div class="col-span-4">
            <label for="product" class="block font-medium text-sm/6">Expected Quantity</label>
            <div class="mt-2">
                <input wire:model="expected_qnty" disabled type="number" id="qnty" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $stock->first()->expected_qnty }}">
            </div>
        </div>
        <div class="col-span-4">
            <label for="product" class="block font-medium text-sm/6">
                Confirm Quantity
                <span class="text-red-800">*</span>
            </label>
            <div class="mt-2">
                <input wire:model='confirm_qnty' type="number" id="confirm_qnty" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" value="">
                @error('confirm_qnty')
                <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="sm:col-span-12">
            <div class="mt-2">
                <button class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Confirm</button>
            </div>
        </div>
    </div>

</form>
