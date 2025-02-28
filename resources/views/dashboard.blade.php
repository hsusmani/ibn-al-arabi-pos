<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ auth()->user()->name }}, welcome
                </h2>
            </x-slot>

            <livewire:dashboard />
        </div>
    </div>
</x-app-layout>
