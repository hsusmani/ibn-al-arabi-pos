<div class="grid grid-cols-12">

    <div class="col-span-4">

        <div class="pr-5 bg-white">

                <div class="grid items-center justify-center grid-cols-1 bg-gray-100 rounded-lg gap-y-2">
                    <img class="w-full rounded-lg" style="mix-blend-mode: darken;" src="{{ $imageSrc ? asset('storage/'.$imageSrc) : asset('storage/img_placeholder.jpg') }} " alt="">
                    <div class="">
                        <h1 class="mt-1 font-medium text-[20px] pb-10 text-center">
                            {{ $name }}
                        </h1>
                    </div>
                </div>
            {{-- <div class="mt-4">
                {{ $products->links() }}
            </div> --}}
        </div>
    </div>
    <div class="col-span-8">
        <form wire:submit.prevent="store" >
            <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">
                <div class="col-span-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">
                        Product Image
                    </label>
                    <div class="mt-2">
                        <input type="file" wire:model.live="image" id="image" class="block w-full text-gray-900 bg-white border border-gray-200 rounded-md shadow-sm sm:text-sm file:px-4 file:py-1.5 file:mr-4 file:bg-blue-600 file:text-white file:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('image')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Product Name
                        <span class="text-red-800">*</span>
                    </label>
                    <div class="mt-2">
                        <input wire:model.live="name" type="text" id="name" placeholder="Enter product name" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('name')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-span-4">
                    <label for="qnty" class="block text-sm font-medium text-gray-700">
                        Quantity
                        <span class="text-red-800">*</span>
                    </label>
                    <div class="mt-2">
                        <input wire:model="qnty"  id="qnty" placeholder="Enter Quantity"
                               class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" >
                    </div>
                    @error('qnty')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                {{-- prices --}}
                <div class="col-span-12">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="price_egp">
                        Prices
                        <span class="text-red-800">*</span>
                    </label>

                    <div class="flex flex-row items-center w-full space-x-5">
                        <div class="flex w-full">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                EGP <span class="text-red-800">*</span>
                            </span>
                            <input id="price_egp" wire:model="price_egp"  class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="flex w-full">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                USD
                            </span>
                            <input id="price_usd" wire:model="price_usd"  class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="flex w-full">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                AED
                            </span>
                            <input id="price_aed" wire:model="price_aed"  class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                        <div class="flex w-full">
                            <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                MAD
                            </span>
                            <input id="price_mad" wire:model="price_mad"  class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        </div>
                    </div>
                    @error('price_egp')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>


                <div class="col-span-4">
                    <label for="cost" class="block text-sm font-medium text-gray-700">
                        Cost (EGP)
                    </label>
                    <div class="mt-2">
                        <input wire:model="cost" id="cost" placeholder="Egyptian Pounds"
                               class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="col-span-4">
                    <label for="barcode" class="block text-sm font-medium text-gray-700">
                        Barcode (ISBN)
                    </label>
                    <div class="mt-2">
                        <input wire:model="barcode" type="text" id="barcode" placeholder="Enter Barcode"
                               class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('barcode')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-span-4">
                    <label for="sku" class="block text-sm font-medium text-gray-700">
                        SKU (For Internal Purpose)
                    </label>
                    <div class="mt-2">
                        <input wire:model="sku" type="text" id="sku" placeholder="This is Auto Generated" class="block w-full px-4 py-2 text-sm bg-gray-100 border border-gray-300 rounded-md shadow-sm placeholder:text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" disabled>
                    </div>
                    @error('sku')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>



                <div class="col-span-4">
                    <label for="weight" class="block text-sm font-medium text-gray-700">
                        Weight
                    </label>
                    <div class="mt-2">
                        <input wire:model="weight"  id="weight" placeholder="Enter weight"
                               class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('weight')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-4">
                    <label for="cover_type" class="block text-sm font-medium text-gray-700">
                        Cover Type
                    </label>
                    <div class="mt-2">
                        <select name="cover_type" id="cover_type" wire:model='cover_type' class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="hard cover">Hard Cover</option>
                            <option value="soft cover">Soft Cover</option>

                        </select>
                    </div>
                    @error('cover_type')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-4">
                    <label for="edition" class="block text-sm font-medium text-gray-700">
                        Edition
                    </label>
                    <div class="mt-2">
                        <select name="edition" id="edition" wire:model='edition' class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>

                        </select>
                    </div>
                    @error('edition')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @php
                    $authors = [
                        'الشيخ الأكبر محيي الدين ابن العربي',
                        'حجة الإسلام أبي حامد الغزالي',
                        'الشيخ أيمن حمدي الأكبري',
                        'الشيخ عبدالغني بن اسماعيل النابلسي',
                        'صدر الدين القونوي',
                        'الإمام القشيري',
                        'الشيخ ولي الله الدهلوي',
                        'حافظ أبي الفضل محمد بن طاهر المقدسي'
                    ];
                @endphp
                <div class="col-span-4">
                    <label for="author" class="block text-sm font-medium text-gray-700">
                        Author
                    </label>

                    <div class="mt-2">
                        <select name="author" id="author" wire:model='author' class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @foreach ($authors as $author)
                            <option value="{{ $author }}">{{ $author }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('author')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                @php
                    $dimensions = [
                        '17x24',
                        '14x20'
                    ];
                @endphp

                <div class="col-span-4">
                    <label for="dimensions" class="block text-sm font-medium text-gray-700">
                        Dimensions
                    </label>
                    <div class="mt-2">
                        <select name="dimensions" id="dimensions" wire:model='dimensions' class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            @foreach ($dimensions as $dimension)
                            <option value="{{ $dimension }}">{{ $dimension }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('dimensions')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-span-4">
                    <label for="pages" class="block text-sm font-medium text-gray-700">
                        Pages
                    </label>
                    <div class="mt-2">
                        <input wire:model="pages"  id="pages" placeholder="Enter No. of Pages"
                               class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('pages')
                        <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>




                <div class="col-span-12">
                    <button type="submit" class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
                </div>
            </div>
        </form>
    </div>

</div>
