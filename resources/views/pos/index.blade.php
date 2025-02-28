<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Point Of Sale') }}
                </h2>
            </x-slot>
        </div>
        @if (session('message'))
            <div class="mb-4 text-sm text-green-800 ">
            {{ session('message') }}
            </div>
        @endif
        <div class="flex flex-col p-10 bg-white border border-gray-200">
            <livewire:p-o-s>
        </div>
    </div>
</x-app-layout>
