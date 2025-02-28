<form wire:submit='store'>
    <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">

        <div class="col-span-6">
            <label for="selling_price" class="block text-sm font-medium text-gray-700">
                Name
                <small class="text-red-800">*</small>
            </label>
            <div class="mt-2">
                <input wire:model="name" type="text" id="name" placeholder="Enter name of the location"
                       class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-6">
            <label for="city" class="block text-sm font-medium text-gray-700">
                City
                <small class="text-red-800">*</small>
            </label>
            <div class="mt-2">
                <input wire:model="city" type="text" id="city" placeholder="Enter city"
                       class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            @error('city')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-6">
            <label for="country" class="block text-sm font-medium text-gray-700">
                Country
                <small class="text-red-800">*</small>
            </label>
            <div class="mt-2">
                <input wire:model="country" type="text" id="country" placeholder="Enter country"
                       class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
            @error('country')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-6">
            <label for="user_ids" class="block text-sm font-medium text-gray-700">
                Asssign Users
                <small class="text-red-800">*</small>
            </label>
            <div class="mt-2">
                <select wire:model="user_ids"  id="user_ids" multiple
                class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Choose Users</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small class="text-red-800">Hold Ctrl to select multiple</small>
            </div>
            @error('user_ids')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-span-12">
            <button type="submit" class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
        </div>
    </div>
</form>
{{--
<form wire:submit="store" class="max-w-4xl p-6 mx-auto bg-white rounded-lg shadow-md">
    <div class="grid grid-cols-12 gap-x-6 gap-y-8">

        <!-- Location Name -->
        <div class="col-span-12 sm:col-span-6">
            <label for="name" class="block text-sm font-medium text-gray-700">
                Location Name
            </label>
            <div class="mt-2">
                <input wire:model="name" type="text" id="name" placeholder="Enter location name"
                       class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            @error('name')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- City -->
        <div class="col-span-12 sm:col-span-6">
            <label for="city" class="block text-sm font-medium text-gray-700">
                City
            </label>
            <div class="mt-2">
                <input wire:model="city" type="text" id="city" placeholder="Enter city"
                       class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            @error('city')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Country -->
        <div class="col-span-12 sm:col-span-6">
            <label for="country" class="block text-sm font-medium text-gray-700">
                Country
            </label>
            <div class="mt-2">
                <input wire:model="country" type="text" id="country" placeholder="Enter country"
                       class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            @error('country')
                <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <!-- Default Checkbox -->
        <div class="col-span-12 sm:col-span-6">
            <label for="default" class="flex items-center gap-2">
                <input {{ $default_found ? 'disabled' : '' }} wire:model="is_default" type="checkbox" id="default"
                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">Set as Default</span>
            </label>
        </div>
        <div class="col-span-12 sm:col-span-6">
            <label for="user" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Please Assign a User</label>
            <select name="user" id="user" wire:model='user_id' multiple class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <small>Hold Ctrl to select multiple</small>
        </div>

        <!-- Submit Button -->
        <div class="col-span-12">
            <button type="submit"
                    class="inline-flex items-center px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Submit
            </button>
        </div>
    </div>
</form> --}}
