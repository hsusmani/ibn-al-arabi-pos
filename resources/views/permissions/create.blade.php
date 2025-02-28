<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
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

                    <form method="POST" action="{{ route('permissions.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    <input type="text" name="name" placeholder="Name" class="form-control">
                                </div>
                            </div>

                            <div class="text-center col-xs-12 col-sm-12 col-md-12">
                                <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
                            </div>
                        </div>
                    </form>




                </div>
            </div>
        </div>
    </div>
</x-app-layout>
