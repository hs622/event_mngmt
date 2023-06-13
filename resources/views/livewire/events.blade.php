<div class="p-6">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if(auth()->user()->roles[0]->slug == 'admin')
        <div class="flex items-centre justify-end px-4 py-3 sm:py-6 text-right">
            <x-button wire:click="createShowModal">
                {{ __('Create') }}
            </x-button>
        </div>
    @endif

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
                                <th class="table-head">Enrollment</th>
                                <th class="table-head"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @if ($events->count())
                                @foreach ($events as $event)
                                    <tr>
                                        <td class="table-data py-4 px-4">
                                            {{ $event->title }}
                                        </td>
                                        <td class="table-data">
                                            {{ $event->schedule->venue }}, {{ $event->schedule->city->name }}, {{ $event->schedule->country->name }}
                                        </td>
                                        <td class="table-data">
                                            {!! $event->enrollments->count() == 0 ? "No one yet enrolled" : $event->enrollments->count() ." people" !!}
                                        </td>
                                        <td class="table-data">
                                            <div class="flex gap-1">
                                                <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" href="{{ route('event.show', $event->slug) }}" >
                                                    {{ __('Show Details') }}
                                                </a>

                                                @if(auth()->user()->roles->first()->slug == 'admin')
                                                    <x-button  wire:click="updateShowModal({{ $event->id }})">
                                                        {{ __('Edit') }}
                                                    </x-button>
                                                    <x-danger-button  wire:click="deleteShowModal({{ $event->id }})">
                                                        {{ __('Delete') }}
                                                    </x-danger-button>
                                                @elseif(auth()->user()->roles->first()->slug == 'speaker' 
                                                    || auth()->user()->roles->first()->slug == 'participant')
                                                    <x-button wire:click="enrolledInEvent({{ $event->id }})">
                                                        {{ __('Enroll') }}
                                                    </x-button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center table-data py-4 px-4" colspan="4">No Results Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Form --}}
    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Create New Event') }} {{ $eventId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="title" value="{{ __('Title') }}" />
                <x-input id="title" class="block mt-1 w-full" type="text" wire:model.defer="event.title" />
                <x-input-error for="event.title" class="mt-2" />
            </div>
            <div class="mt-4 w-full">
                <x-label for="category" value="{{ __('Category') }}" />
                <select id="category" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" wire:model="event.category_id">
                    @if($categories)
                        <option selected value="">-- Select the event category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" wire:key="$category->id" >{{ $category->title }}</option>
                        @endforeach
                    @else
                        <option>-- Select the event category --</option>
                    @endif
                </select>                
                <x-input-error for="event.category_id" class="mt-2" />
            </div> 
            <div class="mt-4">
                <div class="flex flex-row">
                    <div class="mr-1 w-full">
                        <x-label for="country" value="{{ __('Country') }}" />
                        <select id="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" wire:model="event.schedule.country_id">
                            @if($countries)
                                <option selected value="">-- Select the country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" wire:key="$country->id" >{{ $country->name }}</option>
                                @endforeach
                            @else
                                <option>-- Select the country --</option>
                            @endif
                        </select>                
                        <x-input-error for="event.schedule.country_id" class="mt-2" />
                    </div>                    
                    <div class="ml-1 w-full">
                        <x-label for="city" value="{{ __('City') }}" />
                        <select id="city" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" wire:model="event.schedule.city_id">
                            @if($cities)
                                <option selected value="">-- Select the city --</option>
                                @foreach($cities as $key => $cities)
                                    <option value="{{ $key }}" wire:key="$key" >{{ $cities }}</option>
                                @endforeach
                            @else
                                <option>-- Select the city --</option>
                            @endif
                        </select>                
                        <x-input-error for="event.schedule.city_id" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <x-label for="venue" value="{{ __('Venue') }}" />
                {{-- @dump($event->schedule->venue) --}}
                <x-input id="venue" class="block mt-1 w-full" type="text" wire:model.defer="event.schedule.venue" />
                <x-input-error for="event.venue" class="mt-2" />
            </div>
            <div class="mt-4">
                <div class="flex flex-row">
                    <div class="mr-1 w-full">
                        <x-label for="startAt" value="{{ __('Start Datetime') }}" />
                        <x-input id="startAt"  type="datetime-local" class="block mt-1 w-full" wire:model.defer="event.schedule.start_at" />       
                        <x-input-error for="event.schedule.start_at" class="mt-2" />
                    </div>
                    
                    <div class="ml-1 w-full">
                        <x-label for="endAt" value="{{ __('End Datetime') }}" />
                        <x-input type="datetime-local" class="block mt-1 w-full" wire:model.defer="event.schedule.end_at" />      
                        <x-input-error for="event.schedule.end_at" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <x-label for="description" value="{{ __('Event Description') }}" />
                <x-textarea class="w-full" id="description" wire:model.defer="event.description" ></x-textarea>
                <x-input-error for="event.description" class="mt-2" />
            </div>
            <div class="mt-4 flex">
                <input id="checkbox" wire:model="event.status" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="checkbox" class="ml-2 block text-sm text-gray-900">Published</label>                
                <x-input-error for="event.status" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="items-center">
                <x-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
    
                @if ($eventId)
                    <x-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                        {{ __('Update') }}
                    </x-button>
                @else
                    <x-button class="ml-3" wire:click="store" wire:loading.attr="disabled">
                        {{ __('Create') }}
                    </x-button>
                @endif
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Delete Modal --}}
    <x-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            {{ __('Delete Confirmation') }}
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete event?
        </x-slot>

        <x-slot name="footer">
            <div class="items-center">
                <x-secondary-button wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                
                <x-danger-button class="ml-3" wire:click="deleteConfirmed" wire:loading.attr="disabled">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </x-slot>
    </x-dialog-modal>

    {{-- Congurats Model --}}
    <x-dialog-modal wire:model="enrolledModal">
        <x-slot name="title">
            {{ __('Congrats !') }}
        </x-slot>

        <x-slot name="content">
            <strong>{{ auth()->user()->name }}</strong>, you are now enrolled in this event. what to see details? 
        </x-slot>

        <x-slot name="footer">
            <div class="items-center">
                <x-secondary-button wire:click="$toggle('enrolledModal')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
                
                <x-button class="ml-3" wire:click="deleteConfirmed" wire:loading.attr="disabled">
                    {{ __('See Detail') }}
                </x-button>
            </div>
        </x-slot>
    </x-dialog-modal>

</div>