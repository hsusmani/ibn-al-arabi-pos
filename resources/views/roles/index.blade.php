<x-app-layout>
    <div class="mx-auto max-w-7xl">
        <div class="text-gray-900 dark:text-gray-100">
            <x-slot name="header">
                <h2 class="mb-5 text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ __('Roles & Permissions') }}
                </h2>
            </x-slot>


            <div class="flex flex-col">
                <div class="flex flex-row">
                    <a class="px-4 py-2 mb-4 ml-auto text-sm font-semibold text-white bg-blue-600 border border-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300" href="{{ route('roles.create') }}" wire:navigate>
                        Create New Role
                    </a>
                </div>

                <div>
                    @if (session('message'))
                    <div class="mb-4 text-sm text-green-800 ">
                        {{ session('message') }}
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left border border-collapse border-gray-200 rounded-xl">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 border border-gray-200">No.</th>
                                    <th class="px-4 py-3 border border-gray-200">Role</th>
                                    <th class="px-4 py-3 border border-gray-200">Created On</th>
                                    <th class="px-4 py-3 border border-gray-200">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($roles as $role)
                                {{-- @dd($product) --}}
                                    <tr class="hover:bg-gray-50">

                                        <td class="px-4 py-3 text-gray-600">{{ $loop->index + 1 }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $role->name }}</td>
                                        <td class="px-4 py-3 text-gray-600">{{ $role->created_at }}</td>
                                        <td class="px-4 py-3 text-gray-600">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded hover:bg-green-200 focus:outline-none focus:ring focus:ring-green-300">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                            {{-- <a class="btn btn-info btn-sm" href="{{ route('roles.show',$role->id) }}"><i class="fa-solid fa-list"></i> Show</a> --}}
                                            {{-- @can('role-edit')
                                                <a class="btn btn-primary btn-sm" href="{{ route('roles.edit',$role->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                            @endcan --}}

                                            {{-- @can('role-delete')
                                            <form method="POST" action="{{ route('roles.destroy', $role->id) }}" style="display:inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                            </form>
                                            @endcan --}}
                                        </td>


                                        {{-- <td class="px-4 py-3 text-{{ $product->first()->available_qnty == $product['expected_qnty'] ? 'gray-600' : 'red-800' }}">{{ $product['available_qnty'] }}</td> --}}

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
