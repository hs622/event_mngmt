<div class="grid grid-cols-1 p-6 overflow-hidden">
    <div class="bg-white flex justify-between items-center">
        <div class="flex flex-row max-w-4">
            @if($user->profile_photo_path)
                <div class="shrink-0 mr-3 flex items-center">
                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="{{  $user->name }}" />
                </div>
            @else
                <div class="shrink-0 mr-3 flex items-center">1
                    <img class="h-10 w-10 rounded-full object-cover" src="" alt="{{  $user->name }}" />
                </div>
            @endif
            <div class="mx-1">
                <p class="m-0 text-gray-700 text-md">{{ $user->name }} <br> <span class="text-sm"> {{ $user->email }} </span> </p> 
            </div>
        </div>
        @if(!$user->roles->isEmpty())
            <div class="text-left mx-1 ">
                <p class="m-0 text-gray-700 text-sm">Role <br> <span class="text-md"> {{ $user->roles->first()->title }} </span> </p> 
            </div>
        @else
            <div class="text-left mx-1 ">
                <p class="m-0 text-gray-700 text-sm">Role <br> <span class="text-md"> Not assigned. </span> </p> 
            </div>
        @endif
        <div class="text-left mx-1 w-2">
            <p class="m-0 text-gray-700 text-sm">Account Created <br> <span class="text-md"> {{ $user->created_at->format('M d, Y') }} </span> </p> 
        </div>
    </div>
</div>