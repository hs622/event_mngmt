<div class="p-6">
    
        {{-- The data table --}}
        <div class="flex flex-col">
            <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
                <div class="py-2 align-middle inline-block w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left">
                                    <th class="table-head py-4 px-4">Title</th>
                                    <th class="table-head">Venue</th>
                                    <th class="table-head"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                
                                @if (auth()->user()->events->count())
                                    @foreach (auth()->user()->events as $event)
                                        <tr>
                                            <td class="table-data py-4 px-4">
                                                {{ $event->event->title }}
                                            </td>
                                            <td class="table-data">
                                                {{ $event->event->schedule->venue }}, {{ $event->event->schedule->city->name }}, {{ $event->event->schedule->country->name }}
                                            </td>
                                            <td class="table-data">
                                                <div class="flex gap-1">
                                                    <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('event.show', $event->event->slug) }}" >
                                                        {{ __('Show Details') }}
                                                    </a>
    
                                                    @if(auth()->user()->roles[0]->slug == 'admin')
                                                        <x-danger-button  wire:click="deleteShowModal({{ $event->id }})">
                                                            {{ __('Delete') }}
                                                        </x-danger-button>
                                                    @elseif(auth()->user()->roles[0]->slug == 'speaker')
                                                        <x-button  wire:click="enrolledInEvent({{ $event->id }})">
                                                            {{ __('Enroll') }}
                                                        </x-button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center table-data py-4 px-4" colspan="3">There are no registration found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

</div>