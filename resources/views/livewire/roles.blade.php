<div class="p-6">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- The data table --}}

    <div class="flex flex-col">
        <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
            <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="">
                                <th class="table-head py-4 px-4">Name</th>
                                <th class="table-head">Description</th>
                                <th class="table-head">Slug</th>
                                <th class="table-head">Status</th>
                                <th class="table-head">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @if ($roles->count())
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="table-data py-4 px-4 text-center">
                                            {{ $role->title }}
                                        </td>
                                        <td class="table-data text-center">
                                            {{ $role->description }}
                                        </td>
                                        <td class="table-data text-center">
                                            {{ $role->slug }}
                                        </td>
                                        <td class="table-data text-center">
                                            {!! $role->status ? "Active" : "Not Active" !!}
                                        </td>
                                        <td class="table-data text-center">
                                            {{ $role->created_at }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-data" colspan="4">No Results Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>