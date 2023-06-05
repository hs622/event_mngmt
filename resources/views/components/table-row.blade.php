<div class="grid grid-cols-1 p-6 overflow-hidden">
    <div class="bg-white flex justify-between items-center">
        <div class="flex flex-row">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 mr-3 flex items-center">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>
            @endif
            <div class="mx-1">
                <p class="m-0 text-gray-700 text-md">{{ $user->name }} <br> <span class="text-sm"> {{ $user->email }} </span> </p> 
            </div>
        </div>
        <div class="text-left mx-1">
            <p class="m-0 text-gray-700 text-sm">Account Created <br> <span class="text-md"> {{ $user->created_at }} </span> </p> 
        </div>
    </div>
</div>