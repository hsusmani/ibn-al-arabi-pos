<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('View Product') }}
                </h2>
            </x-slot>

            <div class="flex flex-col">

                <div class="p-10 bg-white">

                        <div class="grid items-center grid-cols-2 gap-6">
                            <div class="mr-5">
                                <img class="w-full rounded-lg" src="{{ asset('storage/' . $product->image) }}" alt="">
                            </div>
                            <div>
                                    SKU: {{ $product->sku }} | Barcode: {{ $product->barcode }}
                                <h1 class="mt-1 text-[30px]">
                                    {{ $product->name }}
                                </h1>
                                <div class="mt-1 mb-2 text-lg text-red-700">
                                    Price: {{ session('preferred_currency') }} {{ pricePerCurrency($product->price) }}
                                </div>
                                @if($product->cost)
                                    <div>
                                        Cost: AED {{ $product->cost }}
                                    </div>
                                @endif
                                @if($product->weight)
                                    <div>
                                        Weight: {{ $product->weight }}
                                    </div>
                                @endif
                                @if($product->edition)
                                    <div>
                                        Edition: {{ $product->edition }}
                                    </div>
                                @endif
                                @if($product->author)
                                    <div>
                                        Author: {{ $product->author }}
                                    </div>
                                @endif
                                @if($product->dimensions)
                                    <div>
                                        Dimensions: {{ $product->dimensions }}
                                    </div>
                                @endif
                                @if($product->pages)
                                    <div>
                                         No. of Pages: {{ $product->pages }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    {{-- <div class="mt-4">
                        {{ $products->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
