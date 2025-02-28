<div class="mx-auto max-w-7xl">
        <!-- Grid -->
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 sm:gap-6">
      <!-- Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
          <div class="flex items-center gap-x-2">
            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-neutral-500">
              Total Sales
            </p>
            {{-- <div class="hs-tooltip">
              <div class="hs-tooltip-toggle">
                <svg class="text-gray-500 shrink-0 size-4 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                <span class="absolute z-10 invisible inline-block px-2 py-1 text-xs font-medium text-white transition-opacity bg-gray-900 rounded shadow-sm opacity-0 hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible dark:bg-neutral-700" role="tooltip">
                  The number of daily users
                </span>
              </div> --}}
            {{-- </div> --}}
          </div>

          @php

          $totalAmount = 0;
          if($totalSales->count() != 0) {
            foreach ($totalSales->first()->items as $key => $item) {
                $totalAmount += PricePerCurrency($item['value']['discounted_price']);
            }
        }
          @endphp
          <div class="flex items-center mt-1 gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
              {{ $totalSales->count() != 0 ? $totalSales->count() : 0 }} | {{ session('preferred_currency') }} {{ $totalAmount }}
            </h3>
            {{-- <span class="flex items-center text-green-600 gap-x-1">
              <svg class="self-center inline-block size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
              <span class="inline-block text-sm">
                1.7%
              </span>
            </span> --}}
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
          <div class="flex items-center gap-x-2">
            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-neutral-500">
              Total Cash Sales
            </p>
          </div>

          <div class="flex items-center mt-1 gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                @php
                    $totalCashCount = 0;
                    $totalCashAmount = 0;
                    foreach ($totalSales as $sales) {
                        if($sales->payment_method == 'cash') {
                            $totalCashCount++;
                            $totalCashAmount += $sales->total;
                        }
                    }
                @endphp
                {{ $totalCashCount }} | {{ session('preferred_currency') }} {{ $totalCashAmount }}
            </h3>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
          <div class="flex items-center gap-x-2">
            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-neutral-500">
              Total Cash Sales
            </p>
          </div>

          <div class="flex items-center mt-1 gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
                @php
                    $totalCardCount = 0;
                    $totalCardAmount = 0;
                    foreach ($totalSales as $sales) {
                        if($sales->payment_method == 'card') {
                            $totalCardCount++;
                            $totalCardAmount += $sales->total;
                        }
                    }
                @endphp
                {{ $totalCardCount }} | {{ session('preferred_currency') }} {{ $totalCardAmount }}
            </h3>
          </div>
        </div>
      </div>
      <!-- End Card -->

      <!-- Card -->
      <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
          <div class="flex items-center gap-x-2">
            <p class="text-xs tracking-wide text-gray-500 uppercase dark:text-neutral-500">
              Pageviews
            </p>
          </div>

          <div class="flex items-center mt-1 gap-x-2">
            <h3 class="text-xl font-medium text-gray-800 dark:text-neutral-200">
              92,913
            </h3>
          </div>
        </div>
      </div>
      <!-- End Card -->
    </div>
    <!-- End Grid -->
</div>
  <!-- End Card Section -->
