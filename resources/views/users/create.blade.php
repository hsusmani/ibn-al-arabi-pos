<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Create a User') }}
                </h2>
            </x-slot>

            <div class="grid grid-cols-12 p-10 bg-white gap-x-6 gap-y-8">
                <div class="col-span-12">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('users.store') }}" class="col-span-12">
                    @csrf
                        <div class="grid grid-cols-12 bg-white gap-x-6 gap-y-8">
                            <div class="col-span-6">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Name
                                    <small class="text-red-800">*</small>
                                </label>
                                <div class="mt-2">
                                    <input name="name" type="text" id="name" placeholder="Enter name"
                                           class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="col-span-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email
                                    <small class="text-red-800">*</small>
                                </label>
                                <div class="mt-2">
                                    <input name="email" type="text" id="email" placeholder="Enter name"
                                           class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="col-span-6">
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Password
                                    <small class="text-red-800">*</small>
                                </label>
                                <div class="mt-2">
                                    <input name="password" type="password" id="password" placeholder="Enter password"
                                           class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                            <div class="col-span-6">
                                <label for="confirm-password" class="block text-sm font-medium text-gray-700">
                                    Confirm Password
                                    <small class="text-red-800">*</small>
                                </label>
                                <div class="mt-2">
                                    <input name="confirm-password" type="password" id="confirm-password" placeholder="Confirm password"
                                           class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>




                            {{-- <div class="col-span-6">
                                <label for="role" class="block text-sm font-medium text-gray-700">
                                    Assign Role
                                    <small class="text-red-800">*</small>
                                </label>
                                <div class="mt-2">
                                    <select id="role" name="role" class="block w-full px-4 py-2 text-sm text-gray-900 border border-gray-300 rounded-md shadow-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Choose role</option>
                                        @foreach ($roles as $role)
                                        @if($role->name != 'Super')
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}

                            <div class="col-span-12">
                                <button type="submit" class="px-4 py-2 font-semibold text-blue-700 bg-transparent border border-blue-500 rounded hover:bg-blue-500 hover:text-white hover:border-transparent">Submit</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
