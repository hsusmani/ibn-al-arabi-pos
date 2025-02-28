<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Stock Details') }}
                </h2>
            </x-slot>
            <div class="flex flex-col">
                <div class="flex flex-row items-center justify-end mb-4">
                    <p class="mr-auto text-sm flex-inline">
                        <b>{{ $stocks->first()->product->first()->name }}</b>
                        | SKU:
                        {{ $stocks->first()->product->first()->sku }}
                        | Barcode:
                        {{ $stocks->first()->product->first()->barcode }}
                    </p>
                    @if(isAdmin())
                    <a class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                    href="{{ route('stocks.add', ['stockId' => $stocks[0]->id, 'productId' => $stocks->first()->product->first()->id]) }}" wire:navigate>
                        Add Stock
                    </a>
                    @endif
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
                                    {{-- <th class="px-4 py-3 border border-gray-200">Product</th> --}}
                                    {{-- <th class="px-4 py-3 border border-gray-200">Selling Price</th> --}}
                                    <th class="px-4 py-3 border border-gray-200">Location</th>
                                    <th class="px-4 py-3 border border-gray-200">Expected Quantity</th>
                                    <th class="px-4 py-3 border border-gray-200">Available Quantity</th>
                                    <th class="px-4 py-3 border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($stocks as $stock)
                                {{-- @dd($product) --}}
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $stock->location->first()->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $stock->expected_qnty }}
                                        </td>
                                        <td class="px-4 py-3 text-{{ $stock->expected_qnty > $stock->available_qnty ? 'red' : 'gray' }}-600">
                                            {{ $stock->available_qnty }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            <div class="flex items-center space-x-2">


                                                @unless(!$stock->is_confirmed || $stock->available_qnty == 0)

                                                <a href="{{ route('stocks.transfers', ['stockId' => $stock->id, 'productId' => $stock->product->first()->id]) }}" class="px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded hover:bg-green-200 focus:outline-none focus:ring focus:ring-green-300">
                                                    Transfer
                                                </a>


                                                @if(isAdmin())
                                                <a href="{{ route('stocks.editqnty', ['stockId' => $stock->id, 'productId' => $stock->product->first()->id]) }}" class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring focus:ring-blue-300">
                                                    Edit
                                                </a>
                                                @endif
                                                @endunless
                                                @unless($stock->is_confirmed)
                                                @if($stock->location->first()->id == getUserLocationId())

                                                    <a href="{{ route('confirm.transfers', ['stockId' => $stock->id, 'productId' => $stock->product->first()->id]) }}" class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring focus:ring-blue-300">
                                                        Confirm Transfer
                                                    </a>
                                                @endif
                                                @endunless
                                            </div>
                                        </td>
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
</x-app-layout>
