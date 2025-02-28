<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Stocks') }}
                </h2>
            </x-slot>
            <div class="flex flex-col">
                <a class="px-4 py-2 mb-4 ml-auto text-sm font-semibold text-white bg-blue-600 border border-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300" href="{{ route('stocks.create') }}" wire:navigate>
                    Add New Stock
                </a>
                {{-- <select name="" id="">
                            <option value="">
                                All
                            </option>
                            @foreach ($locations as $location)
                            <option value="">{{ $location }}</option>
                            @endforeach
                        </select> --}}
                        <div>

                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}

                    </div>
                    @endif
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-collapse border-gray-200 rounded-xl">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-4 py-3 border border-gray-200">No.</th>
                                <th class="px-4 py-3 border border-gray-200">Product Name</th>
                                {{-- <th class="px-4 py-3 border border-gray-200">Location</th> --}}
                                <th class="px-4 py-3 border border-gray-200" style="max-width: 80px">Expected Qnty</th>
                                <th class="px-4 py-3 border border-gray-200" style="max-width: 80px">Available Qnty</th>
                                <th class="px-4 py-3 border border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($StockArray as $stock)
                            <tr>
                                <td class="px-4 py-3 text-gray-600">{{ $loop->index+1 }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $stock['name'] }}</td>
                                {{-- <td class="px-4 py-3 text-gray-600">{{ $stock->location->name }}</td> --}}
                                <td class="px-4 py-3 text-gray-600" style="max-width: 80px">{{ $stock['expected_qnty'] }}</td>
                                <td class="px-4 py-3 text-gray-600" style="max-width: 80px">{{ $stock['available_qnty'] }}</td>
                                <td class="px-4 py-3 text-gray-600">

                                    <a href="{{ route('stocks.details', ['ids' => json_encode($stock['stock_ids'])]) }}" class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring focus:ring-blue-300">
                                        Details
                                    </a>



                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
                </div>

</x-app-layout>
