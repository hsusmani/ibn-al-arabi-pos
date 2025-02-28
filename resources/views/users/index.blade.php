<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Users') }}
                </h2>
            </x-slot>


            <div class="flex flex-col">
                <a class="px-4 py-2 mb-4 ml-auto text-sm font-semibold text-white bg-blue-600 border border-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300" href="{{ route('users.create') }}" wire:navigate>
                    Create a User
                </a>


                <div>
                    @if (session('success'))
                    <div class="mb-4 text-sm text-green-800 ">
                        {{ session('success') }}
                    </div>
                    @endif


                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-collapse border-gray-200 rounded-xl">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 border border-gray-200">No.</th>
                                    <th class="px-4 py-3 border border-gray-200">Name</th>
                                    <th class="px-4 py-3 border border-gray-200">Email</th>
                                    <th class="px-4 py-3 border border-gray-200">Role</th>
                                    <th class="px-4 py-3 border border-gray-200">Created On</th>
                                    <th class="px-4 py-3 border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($data as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                                        <td class="px-4 py-3 text-gray-600">
                                            @foreach($user->getRoleNames() as $role)
                                            {{ $role }}
                                                @unless ($loop->last)
                                                    |
                                                @endunless
                                            @endforeach
                                        </td>
                                        <td class="px-4 py-3 text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-4 py-3 text-gray-600">
                                            <div class="flex items-center space-x-2">
                                                {{-- <a href="{{ route('locations.edit', [$location->id]) }}" class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-100 rounded hover:bg-blue-200 focus:outline-none focus:ring focus:ring-blue-300" aria-label="Edit {{ $product->name }}">
                                                    Edit
                                                </a> --}}
                                                {{-- <form action="{{ route('users.destroy', [$user->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 text-sm font-medium text-red-600 bg-red-100 rounded hover:bg-red-200 focus:outline-none focus:ring focus:ring-red-300" aria-label="Delete {{ $user->name }}">
                                                        Delete
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-4">
                        {{ $products->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

