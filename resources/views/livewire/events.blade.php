<div class="p-6">
    <div class="flex items-centre justify-end px-4 py-3 sm:py-6 text-right">
        <x-button wire:click="createShowModal">
            {{ __('Create') }}
        </x-button>
    </div>

    {{-- The data table --}}

    <div class="flex flex-col">
        <div class="my-2 overflow-x-auto sm:mx-6 lg:mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    {{-- <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="table-head">Title</th>
                                <th class="table-head">Link</th>
                                <th class="table-head">Content</th>
                                <th class="table-head"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @if ($pages->count())
                                @foreach ($pages as $page)
                                    <tr>
                                        <td class="table-data">
                                            {{ $page->title }}
                                            {!! $page->is_default_home ? '<span class="text-green-600 text-sm font-bold">[Default Home Page]</span>' : '' !!}
                                            {!! $page->is_default_404 ? '<span class="text-red-600 text-sm font-bold">[Default 404 Error Page]</span>' : '' !!}
                                        </td>
                                        <td class="table-data">
                                            <a href="{{ URL::to('/' . $page->slug) }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                {{ $page->slug }}
                                            </a>
                                        </td>
                                        <td class="table-data">{!! \Illuminate\Support\Str::limit($page->content, 50, '...') !!}</td>
                                        <td class="table-data flex justify-end gap-2">
                                            <x-jet-button wire:click="updateShowModal({{ $page->id }})">
                                                {{ __('Edit') }}
                                            </x-jet-button>
                                            <x-jet-danger-button wire:click="deleteShowModal({{ $page->id }})">
                                                {{ __('Delete') }}
                                                </x-jet-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="table-data" colspan="4">No Results Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table> --}}
                </div>
            </div>
        </div>
    </div>

    <br />
    {{-- {{ $pages->links() }} --}}

    {{-- Modal Form --}}
    <x-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Create New Event') }} {{ $modelId }}
        </x-slot>

        <x-slot name="content">
            <div class="mt-4">
                <x-label for="title" value="{{ __('Title') }}" />
                <x-input id="title" class="block mt-1 w-full" type="text" name="title" wire:model.defer="event.title" />
                <x-input-error for="event.title" class="mt-2" />
            </div>
            <div class="mt-4">
                <div class="flex flex-row">
                    <div class="mr-1 w-full">
                        <x-label for="country" value="{{ __('Country') }}" />
                        <select id="country" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" wire:model="selectedCountry">
                            @if($countries)
                                <option>-- Select the country --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" wire:key="$country->id" >{{ $country->name }}</option>
                                @endforeach
                            @else
                                <option>-- Select the country --</option>
                            @endif
                        </select>                
                        <x-input-error for="event.country" class="mt-2" />
                    </div>
                    
                    <div class="ml-1 w-full">
                        <x-label for="city" value="{{ __('City') }}" />
                        <select id="city" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" wire:model="event.city">
                            @if($cities)
                                <option>-- Select the city --</option>
                                @foreach($cities as $key => $cities)
                                    <option value="{{ $key }}" wire:key="$key" >{{ $cities }}</option>
                                @endforeach
                            @else
                                <option>-- Select the city --</option>
                            @endif
                        </select>                
                        <x-input-error for="event.city" class="mt-2" />
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <x-label for="venue" value="{{ __('Venue') }}" />
                <x-input id="venue" class="block mt-1 w-full" type="text" name="venue" wire:model.defer="event.venue" />
                <x-input-error for="event.venue" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-label for="description" value="{{ __('Event Description') }}" />
                <x-textarea class="w-full" id="description" wire:model.defer="event.description" />
                <x-input-error for="event.description" class="mt-2" />
            </div>
            <div class="mt-4 flex">
                <input id="checkbox" wire:model.defer="event.status" name="checkbox" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="checkbox" class="ml-2 block text-sm text-gray-900">Published</label>                
                <x-input-error for="event.status" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="items-center">
                <x-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>
    
                @if ($modelId)
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
</div>