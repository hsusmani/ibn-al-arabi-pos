<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Products') }}
                </h2>
            </x-slot>


            <div class="flex flex-col">
                <div class="flex flex-row ml-auto">
                    @if(auth()->user()->hasRole('Super'))
                    <a class="px-4 py-2 mb-4 text-sm font-semibold text-white bg-green-600 border border-green-500 rounded hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300" href="{{ route('products.import') }}" wire:navigate>
                        Import
                    </a>
                    @endif

                    @if(isAdmin())
                    <a class="px-4 py-2 mb-4 ml-2 text-sm font-semibold text-white bg-blue-600 border border-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300" href="{{ route('products.create') }}" wire:navigate>
                        Create New Product
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
                                    <th class="px-4 py-3 border border-gray-200">Product</th>
                                    <th class="px-4 py-3 border border-gray-200">Selling Price</th>
                                    <th class="px-4 py-3 border border-gray-200">Expected Quantity</th>
                                    <th class="px-4 py-3 border border-gray-200">Available Quantity</th>
                                    <th class="px-4 py-3 border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($products as $product)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                                    <td class="flex flex-row items-center px-4 py-3 text-gray-600">
                                            <img src="{{ $product->image ? asset('storage/' . $product->image) :  asset('storage/' . 'img_placeholder.jpg' )}}" class="rounded shadow-sm w-14 h-14">
                                            <div class="flex flex-col px-3">
                                                <div>{{ $product->name }}</div>
                                                <small>SKU: {{ $product->sku }}</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ pricePerCurrency($product->price) }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $product->stocks->sum('expected_qnty') }}
                                        </td>
                                        <td class="px-4 py-3 text-{{ $product->stocks->sum('expected_qnty') > $product->stocks->sum('available_qnty') ? 'red' : 'gray' }}-600">
                                            {{ $product->stocks->sum('available_qnty') }}
                                        </td>
                                        {{-- <td class="px-4 py-3 text-{{ $product->first()->available_qnty == $product['expected_qnty'] ? 'gray-600' : 'red-800' }}">{{ $product['available_qnty'] }}</td> --}}
                                        <td class="px-4 py-3 text-gray-600">
                                            <div class="flex items-center space-x-2">
                                                @if (isAdmin())
                                                <a href="{{ route('products.edit', [$product->id]) }}" class="px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded hover:bg-green-200 focus:outline-none focus:ring focus:ring-green-300">
                                                    <i class="ri-pencil-line"></i>
                                                </a>
                                                @endif

                                                @if(isAdmin())
                                                <a href="{{ route('stocks.details', [$product->id]) }}" class="px-3 py-1 text-sm font-medium text-pink-600 bg-pink-100 rounded hover:bg-pink-200 focus:outline-none focus:ring focus:ring-blue-300">
                                                    Stock Details
                                                </a>
                                                @elseif(!isAdmin() && $product->stocks->sum('expected_qnty') > 0 )
                                                <a href="{{ route('stocks.details', [$product->id]) }}" class="px-3 py-1 text-sm font-medium text-pink-600 bg-pink-100 rounded hover:bg-pink-200 focus:outline-none focus:ring focus:ring-blue-300">
                                                    Stock Details
                                                </a>
                                                @endif

                                                {{-- <form action="{{ route('products.destroy', [$product->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-sm font-medium text-red-600 bg-red-100 rounded hover:bg-red-200 focus:outline-none focus:ring focus:ring-red-300">
                                                        Delete
                                                    </button>
                                                </form> --}}

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
