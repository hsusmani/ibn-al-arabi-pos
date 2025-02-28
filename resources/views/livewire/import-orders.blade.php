<div class="flex flex-col">
    <div>
        @if (session('message'))
        <div class="mb-4 text-sm text-green-800 ">
            {{ session('message') }}
        </div>
        @endif

        <div class="grid items-end grid-cols-12">
            <div class="col-span-3">
                <label for="file" class="block text-sm font-medium text-gray-700">
                    Upload File
                    <span class="text-red-800">*</span>
                </label>
                <div class="mt-2">
                    <input type="file" wire:model.live="file" id="file" class="block w-full text-gray-900 bg-white border border-gray-200 rounded-md shadow-sm sm:text-sm file:px-4 file:py-1.5 file:mr-4 file:bg-blue-600 file:text-white file:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('file')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-span-3">
                <button type="button" wire:click='processImport' class="px-4 py-2 ml-2 text-sm font-semibold text-white bg-{{ $items ? 'blue-600' : 'gray-300' }} border border-{{ $items ? 'blue-500' : 'gray-300' }} rounded hover:bg-{{ $items ? 'blue-700' : 'gray-300' }} focus:outline-none focus:ring focus:ring-blue-300" @unless($items) disabled @endunless>
                    Process Import
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12">


            <div class="col-span-12 mt-10">
                <table class="w-full text-sm text-left border border-collapse border-gray-200 rounded-xl">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 border border-gray-200">No.</th>
                            <th class="px-4 py-3 border border-gray-200">Order ID</th>
                            <th class="px-4 py-3 border border-gray-200">Items</th>
                            <th class="px-4 py-3 border border-gray-200">Total</th>
                            <th class="px-4 py-3 border border-gray-200">Customer</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if($items)
                        @foreach ($items as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1}}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $item['id'] }}</td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="flex flex-col">
                                        @foreach ($item['items'] as $i)
                                            <div>{{ $i['name'] }} x {{ $i['qnty'] }}</div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    @php
                                        $total = 0;
                                        foreach($item['items'] as $i) {
                                            $total += PricePerCurrency($i['value']['discounted_price']);
                                        }

                                    @endphp
                                    {{ $total }}
                                </td>
                                <td class="px-4 py-3 text-gray-600">
                                    <div class="flex flex-col">
                                        <div style="white-space: nowrap">Name : {{ $item['customer_name'] }}</div>
                                        <div style="white-space: nowrap">Phone : {{ $item['customer_phone'] }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                            <td class="px-4 py-3 text-gray-600"><div class="bg-gray-300 rounded-full" style="width: 25px; height: 7px"></div></td>
                        </tr>

                        @endif

                    </tbody>
                </table>

            </div>

        </div>




    </div>
</div>
