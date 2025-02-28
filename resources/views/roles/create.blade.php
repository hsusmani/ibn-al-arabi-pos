<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Create & Edit Roles') }}
                </h2>
            </x-slot>
            <div class="flex flex-col p-10 bg-white border border-gray-200">
                <livewire:CreateEditRoles :id="$id = NULL">
            </div>


        </div>
    </div>
</x-app-layout>
