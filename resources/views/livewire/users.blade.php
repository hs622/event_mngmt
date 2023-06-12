<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white sm:rounded-lg">
            <x-table>
                @if($users)
                    @foreach($users as $key => $user)
                        <x-table-row :user="$user" wire:key="$user->id"/>
                    @endforeach
                @else
                    {{-- <x-table-row /> --}}
                @endif
            </x-table>
        </div>
    </div>
</div>
