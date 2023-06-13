<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white px-6 sm:rounded-lg">
            <ul role="list" class="divide-y divide-gray-100">
                @foreach($users as $user)
                    <li class="flex justify-between gap-x-6 py-5">
                        <div class="flex gap-x-4">
                            @if($user->profile_photo_path)
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ asset('storage/'.$user->profile_photo_path) }}">
                            @else
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="" alt="">
                            @endif
                            <div class="min-w-0 flex-auto">
                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ Str::ucfirst($user->name) }}</p>
                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            @if(!$user->roles->isEmpty())
                                <p class="text-sm leading-6 text-gray-900">{{ Str::ucfirst($user->roles->first()->title) }}</p>
                            @else
                                <p class="text-sm leading-6 text-gray-900"> No Assigned Role </p>    
                            @endif
                            <p class="mt-1 text-xs leading-5 text-gray-500">Account Created: <time datetime="{{ $user->created_at }}">{{ $user->created_at->format('d M, Y') }}</time></p>
                        </div>
                    </li>
                @endforeach
            </ul>
        
        </div>
    </div>
</div>
