<div class="flex flex-col">
    <div class="flex flex-row items-end justify-end mb-4 space-x-3">
        <div class="flex flex-col">
            <small>Location</small>
            <select wire:model.change="location" id="location" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option>All</option>
                @foreach ($locations as $location)
                    <option wire:key='{{ $location['id'] }}' value='{{ $location['id'] }}'>{{ $location['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <small>From</small>
            <input wire:model.live="from" type="date" id="from" placeholder="Choose Start Date" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="flex flex-col">
            <small>To</small>
            <input wire:model.live="to" type="date" id="from" placeholder="Choose End Date" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <button type="button" wire:click="download" class="px-4 py-2 text-sm font-semibold text-white bg-{{ empty($orderIds) ? 'gray' : 'blue' }}-600 border border-{{ empty($orderIds) ? 'gray' : 'blue' }}-500 rounded hover:bg-{{ empty($orderIds) ? 'gray' : 'blue' }}-700 focus:outline-none focus:ring focus:ring-{{ empty($orderIds) ? 'gray' : 'blue' }}-300" wire:navigate {{ empty($orderIds) ? 'disabled' : ''}}>
            Download Report
        </button>
    </div>


    <div>
        @if (session('message'))
        <div class="mb-4 text-sm text-green-800 ">
            {{ session('message') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border border-collapse border-gray-200 rounded-xl">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 border border-gray-200">No.</th>
                        {{-- <th class="px-4 py-3 border border-gray-200">Order Id</th> --}}
                        <th class="px-4 py-3 border border-gray-200">Product</th>
                        <th class="px-4 py-3 border border-gray-200">Quantity</th>
                        <th class="px-4 py-3 border border-gray-200">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($sales as $key => $sale)
                        <tr class="hover:bg-gray-50" wire:key='item-{{ $loop->index }}'>
                            <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $sale['name'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $sale['qnty'] }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $sale['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- <div class="mt-4">
            {{ $products->links() }}
        </div> --}}
    </div>
</div>
</div>
</div>
