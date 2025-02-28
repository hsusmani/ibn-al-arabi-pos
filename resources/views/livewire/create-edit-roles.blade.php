<div class="grid grid-cols-12 space-y-5">

    <div class="col-span-4">
        <label for="roleName" class="block text-sm font-medium text-gray-700">
            Role Name
        </label>
        <div class="mt-2">
            <input type="text" wire:model="roleName" id="roleName" class="block w-full text-gray-900 bg-white border border-gray-200 rounded-md shadow-sm sm:text-sm file:px-4 file:py-1.5 file:mr-4 file:bg-blue-600 file:text-white file:text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        @error('roleName')
            <span class="text-sm text-red-500">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-span-12">
        <label for="permissions" class="block text-sm font-medium text-gray-700">
            Permissions
        </label>
        <div class="flex flex-wrap">

            @foreach ($permissions as $permission)
            <div class="flex items-center my-5 me-5" wire:key='{{ $loop->index }}'>
                <input id="item-{{ $loop->index }}" type="checkbox" wire:model='permissionsSelected.{{ $permission->id }}' class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" value="{{ $permission->name }}">
                <label for="item-{{ $loop->index }}" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300" >{{ $permission->name }}</label>
            </div>
            @endforeach
        </div>

    </div>
    <div class="col-span-12">
        <button type="button" wire:click="save" class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
    </div>



</div>
