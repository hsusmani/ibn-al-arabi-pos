<div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">

    <div class="col-span-6">
        <div class="grid grid-cols-12 gap-x-6">
            @if (auth()->user()->hasRole('Super') || auth()->user()->hasRole('Admin'))
            <div class="col-span-6">
                <label for="location-selector" class="block mb-2 text-sm font-medium text-gray-700">Select Locations</label>
                <select wire:model.change="location" id="location" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @foreach ($locations as $location)
                        <option wire:key='{{ $location['id'] }}' value='{{ $location['id'] }}'>{{ $location['name'] }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-span-6">
                <label for="search" class="block mb-2 text-sm font-medium text-gray-700">
                    Search
                </label>
                <div class="mt-2">
                    <input wire:model.live='search' type="text" id="search" placeholder="Enter SKU, ISBN or Name" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <div class="col-span-12 mt-3">
                <small class="text-red-800">

                    <span id="itemCount">
                        @php
                            $count = 0;
                            foreach ($items as $item) {
                                if ($item['visible'] == 1) {
                                    $count++;
                                }
                            }
                        @endphp
                    </span>
                    @if($location == NULL)
                    No Location Assigned. Request for a location.
                    @else
                    {{ $count }} Products Available
                    @endif

                </small>
            </div>
            <div class="col-span-12">
                <div class="grid grid-cols-12 gap-6 mt-5">
                @foreach ($items as $item)
                    <div wire:key='items-{{ $loop->index }}' class="{{ $item['visible'] == 1 ? 'visible' : 'hidden' }} rounded-lg bg-[#fafafa] border col-span-6 relative item" data-sku='{{ $item['sku'] }}' data-name='{{ $item['name'] }}' data-barcode='{{ $item['barcode'] }}'>
                        <div class="product-{{ $loop->index }}">
                            <button class="absolute right-2 top-2 info-button" data-id="{{ $loop->index }}">
                                <img src="{{ asset('storage/information-button.png') }}" alt="" width="25" height="25">
                            </button>
                            <img src="{{ $item['image'] ? asset('storage') . '/' . $item['image'] : asset('storage') . '/' .'img_placeholder.jpg' }}" class="rounded-lg">
                            <div class="px-5 pb-1 mt-2">
                                <p class="text-sm text-gray-400">SKU: {{ $item['sku'] }}</p>
                                <h3 class="font-medium text-gray-800 text-md ">{{ $item['name'] }}</h3>
                                <p class="text-sm text-red-800" wire:model='{{ $item['available_qnty'].$loop->index }}'>Available Qnty: {{ $item['available_qnty'] ? $item['available_qnty'] : '0' }}</p>
                                <div class="flex items-center justify-between mt-3 mb-2">
                                    <span class="text-gray-800">
                                        {{ session('preferred_currency') }}
                                        @if(session('preferred_currency') == 'EGP') {{ $item['price_egp'] }} @endif
                                        @if(session('preferred_currency') == 'USD') {{ $item['price_usd'] }} @endif
                                        @if(session('preferred_currency') == 'AED') {{ $item['price_aed'] }} @endif
                                        @if(session('preferred_currency') == 'MAD') {{ $item['price_mad'] }} @endif
                                    </span>
                                    <button wire:click='addToCart({{ $loop->index }})' class="px-4 py-2 text-white bg-blue-700 rounded addtocart hover:bg-blue-800">
                                        <i class="ri-shopping-cart-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-lg text-sm text-black bg-[#c6ffdc] px-5 py-2 absolute top-0 left-0 flex-col justify-center w-full info-bar hidden" data-id="{{ $loop->index }}">
                            <button class="absolute right-2 top-2">
                                <img src="{{ asset('storage/close.png') }}" alt="" width="25" height="25">
                            </button>
                            @foreach ($stocksInfo as $info)
                            @if($info['product'][0]['id'] == $item['id'])
                            <div class="flex flex-row">
                                {{ $info['location'][0]['name'] }}: <span class="ml-1 font-bold">{{ $info['available_qnty'] }}</span>
                            </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
                    </div>
                </div>
            </div>
    <div class="col-span-6">
        <form wire:submit.prevent="store" class="relative">
            <div class="w-full">
                <div class="flex flex-col">
                    <h2 class="text-xl font-semibold">Cart Summary</h2>


                    @empty($cartItems)
                    <small class="text-red-800">Your Cart is Empty</small>
                    @endempty
                    @error('cartItems')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <ul class="mt-4 space-y-4">

                        @foreach ($cartItems as $cartItem)
                            <li wire:key='cart-{{ $loop->index }}' class="flex items-center justify-between p-4 bg-[#fafafa]">
                                <div class="flex flex-row">

                                    <div class="flex flex-col">
                                        <div class="my-0">{{ $cartItem['name'] }}</div>
                                        <small class="my-0">
                                            {{ session('preferred_currency') }}
                                            @if(session('preferred_currency') == 'EGP') {{ $cartItem['price_egp'] }} @endif
                                            @if(session('preferred_currency') == 'USD') {{ $cartItem['price_usd'] }} @endif
                                            @if(session('preferred_currency') == 'AED') {{ $cartItem['price_aed'] }} @endif
                                            @if(session('preferred_currency') == 'MAD') {{ $cartItem['price_mad'] }} @endif
                                        </small>
                                        <small class="my-0">Available: {{ $cartItem['available_qnty'] }}</small>
                                    </div>
                                </div>
                                <div class="custom-number-input">
                                    <div class="flex flex-row items-end gap-x-2">
                                        <div class="inline-flex flex-col">
                                            <div class="flex flex-row items-center mb-1">
                                                <label class="text-sm" for="qnty.{{ $loop->index }}">Qnty</label>
                                                <span class="ml-auto">
                                                    <button style="padding: 0 7px;" class="text-sm text-white bg-red-700 rounded-full hover:bg-red-800" type="button" wire:click='minus({{ $loop->index }})'>-</button>
                                                    <button style="padding: 0 6px;" class="text-sm text-white bg-blue-700 rounded-full hover:bg-blue-800" type="button" wire:click='plus({{ $loop->index }})'>+</button>
                                                </span>
                                            </div>
                                            <input wire:change='qnty({{ $loop->index }})' wire:model='{{ $cartItem['qnty'].$loop->index }}' type="number" style="max-width: 80px;" class="px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="{{ $cartItem['qnty'] }}" disabled>
                                        </div>
                                        <div class="relative inline-flex flex-col">
                                            <label class="text-sm" for="singleDiscount.{{ $loop->index }}">Disc</label>
                                            <div class="relative">
                                                <input id="singleDiscount.{{ $loop->index }}" wire:change='singleDiscount({{ $loop->index }}, $event.target.value)' wire:model.live='cartItems.{{ $loop->index }}.discount' type="number" style="width: 80px;" min="0" max="100" class="px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" >
                                                <span class="absolute right-3" style="top: 50%; transform: translateY(-50%);">%</span>
                                            </div>
                                        </div>

                                        <div class="inline-flex flex-col">
                                            <label class="text-sm" for="sub_total.{{ $loop->index }}">Price</label>
                                            <input class="px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model='{{ $cartItem['subTotal'].$loop->index }}' type="number" style="max-width: 80px;" disabled value="{{ $cartItem['subTotal'] }}">
                                        </div>
                                        {{-- <button type="button" wire:click='remove_from_cart({{ $item['id'] }})' class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">x</button> --}}
                                    </div>
                                </div>
                            </li>

                        @endforeach

                </ul>



            </div>
            <div class="flex flex-col items-end mt-5 gap-y-2">
                <div class="relative flex items-center justify-end gap-x-6">
                    <span>Discount:</span>
                    <input wire:model.live='discount' type="number" style="width: 90px;" min="0" max="100" class="{{ empty($cartItems) ? 'px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500' : 'text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500'}}" {{ empty($cartItems) ? 'disabled' : ''}}>
                    <span class="absolute top-50 right-3">%</span>
                </div>
                <div>
                    @error('discount')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex items-center justify-end gap-x-6">
                    <span>Total:</span>
                    <input class="px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" wire:model='total' type="number" style="width: 90px;" disabled>
                </div>
                <div>
                    @error('total')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="button" id="openCheckout" class="px-4 py-2 mt-3 text-white bg-green-700 rounded hover:bg-green-800" wire:click='openCheckoutForm'>Checkout</button>
            </div>

        </form>
    </div>
    <div class="fixed top-0 left-0 z-50
    @if ($checkOutForm == 0)
    {{ 'hidden' }}
    @else
    {{ 'flex' }}
    @endif
    col-span-12" style="width: 100%; height: 100%" id="checkOutForm">
        <div class="absolute w-full h-full bg-gray-900 opacity-60" wire:click='closeCheckoutForm'></div>
        <div class="z-50 flex flex-col items-center justify-center mx-auto" >
            <div class="relative px-10 py-10 bg-white rounded-lg">
                <h1 class="font-bold text-md">Cehckout</h1>
                <small class="text-red-800">Before Checkout, please fill in details:</small>
                <button id="closeCheckout" class="absolute px-4 py-2 text-white bg-red-700 rounded-lg hover:bg-red-800 top-3 right-3" wire:click='closeCheckoutForm'>x</button>
                <div class="flex flex-col mt-4 space-y-2">
                    <div class="hidden">
                            <input wire:model="orderHasDiscount" disabled>
                    </div>

                    <div>
                        <label for="customer" class="block mb-2 text-sm font-medium text-gray-700">
                            Customer Name @unless($orderHasDiscount == true) (optional) @endunless
                        </label>
                        <div class="mt-2">
                            <input wire:model="customer" type="text" id="customer" placeholder="Enter Customer Name" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        @error('customer')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">
                            Customer Phone @unless($orderHasDiscount == true) (optional) @endunless
                        </label>
                        <div class="mt-2">
                            <input wire:model="phone" type="text" id="phone" placeholder="Enter Customer Phone" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        @error('phone')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    @unless($orderHasDiscount == false)
                    <div>
                        <label for="discountNote" class="block mb-2 text-sm font-medium text-gray-700">
                            Discount Note
                        </label>
                        <div class="mt-2">
                            <textarea wire:model='discountNote' id="discountNote" rows="3" placeholder="Enter Discount Note" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            @error('discountNote')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @endunless

                    <div class="flex flex-col">
                        <label for="customer" class="block mb-2 text-sm font-medium text-gray-700">
                            Payment Method
                        </label>
                        <div class="inline-flex items-center space-x-2">
                            <div class="inline-flex items-center">
                                <input id="cash" type="radio" wire:model="payment" value="cash" name="payment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" checked>
                                <label for="cash" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Cash</label>
                            </div>
                            <div class="flex items-center">
                                <input id="card" type="radio" wire:model="payment" value="card" name="payment" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="card" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Card</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div>
                        <label for="customer" class="block mb-2 text-sm font-medium text-gray-700">
                            Paid Amount
                        </label>
                        <div class="mt-2">
                            <input wire:model="paid_amount" type="number" id="customer" placeholder="Enter Amount Paid" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div> --}}
                    <div class="space-x-2">
                        <button class="px-4 py-2 mt-3 text-white bg-green-700 rounded hover:bg-green-800" wire:click='checkout(1)'>Receipt</button>
                        <button class="px-4 py-2 mt-3 text-white bg-gray-600 rounded hover:bg-gray-800" wire:click='checkout(0)'>No Receipt</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- <div class="{{ $modal == 0 ? 'hidden' : 'absolute' }}  top-0 left-0 z-50 flex flex-row items-center justify-center w-full h-full">
    <div class="absolute w-full h-full bg-gray-500 opacity-[0.3]"></div>
    <div class="relative px-8 py-6 bg-white rounded-lg">
        <h5 class="mb-2 text-sm text-red-800">Please enter details to confirm:</h5>
        <div class="mt-4">
            <label for="customer" class="block mb-2 text-sm text-gray-700">
                Customer Name:
            </label>
            <div class="mt-2">
                <input wire:model="customer" type="text" id="customer" placeholder="Enter Customer Name" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>
        <div class="mt-4">
            <label for="discount_note" class="block mb-2 text-sm text-gray-700">
                Order Note:
            </label>
            <div class="mt-2">
                <textarea class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="discount_note" id="discount_note" rows="5" placeholder="Enter Order Discount Note"></textarea>
            </div>
        </div>
        <div class="mt-4">
            <label for="discount_note" class="block mb-2 text-sm text-gray-700">
                Payment Method:
            </label>
            <div class="flex mt-2 flex-inline gap-x-4">
                <div class="flex items-center mb-4">
                    <input wire:model='payment_method' id="cash" type="radio" value="cash" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="cash" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Cash</label>
                </div>
                <div class="flex items-center mb-4">
                    <input wire:model='payment_method' id="card" type="radio" value="card" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="card" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Card</label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="px-10 py-2 text-white bg-green-500 rounded hover:bg-green-600">Checkout</button>
        </div>

    </div>
</div>
 --}}

 {{-- <script>
     const searchInput = document.getElementById('search');
     const locationEl = document.getElementById('location');
     const items = document.querySelectorAll('.item');

     locationEl.addEventListener('change', function() {
        items.forEach(item => {
            searchInput.value = '';
            item.classList.add('visible');
            item.classList.remove('hidden');
        })
     })


     searchInput.addEventListener('input', function(e) {
         items.forEach(item => {
            let sku = item.getAttribute('data-sku');
            let name = item.getAttribute('data-name');
            let barcode = item.getAttribute('data-barcode');
            if(sku.includes(e.target.value) || name.includes(e.target.value) || barcode.includes(e.target.value)) {
                item.classList.add('visible');
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
                item.classList.remove('visible');
            }

        });


    })

 </script> --}}

 <script>
    const infoBtns = document.querySelectorAll('.info-button');
    const infoBars = document.querySelectorAll('.info-bar button');

    infoBtns.forEach(function(item) {
        item.addEventListener('click', function(e) {
            let dataId = Number(e.currentTarget.getAttribute("data-id"));
            let infoBar = document.querySelector(".info-bar[data-id='"+dataId+"']")
            infoBar.classList.remove('hidden');
            infoBar.classList.add('flex');
        })
    })
    infoBars.forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.currentTarget.parentNode.classList.remove('flex');
            e.currentTarget.parentNode.classList.add('hidden');

        })
    })

 </script>
</div>
