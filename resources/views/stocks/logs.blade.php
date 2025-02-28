<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Stock Logs') }}
                </h2>
            </x-slot>
            <div class="flex flex-col">
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
                                    <th class="px-4 py-3 border border-gray-200">Action</th>
                                    <th class="px-4 py-3 border border-gray-200">From</th>
                                    <th class="px-4 py-3 border border-gray-200">To</th>
                                    <th class="px-4 py-3 border border-gray-200">Quantity</th>
                                    <th class="px-4 py-3 border border-gray-200">User Name</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($logs as $log)
                                {{-- @dd($product) --}}
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $log['action'] }}</td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $log['from'] }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $log['to'] }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $log['qnty'] }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">
                                            {{ $log['user'] }}
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
