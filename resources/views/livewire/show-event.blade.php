<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white sm:rounded-lg">
            {{-- @dump($event, $event->schedule, $event->enrollments->count()) --}}
            <div class="container mx-auto">
                <div class="max-w-4xl mx-auto">
                  <!-- Product details -->
                  <div class="py-7 flex flex-col md:flex-col">
                    <!-- Product image -->

                      <h2 class="text-2xl font-bold">{{ $event->title }}</h2>
                      <p class="text-gray-700 mb-4">{{ $event->category->title }}</p>
                      <p class="text-2 font-bold mb-4">{{ $event->description }}</p>
                      <p class="text-2 font-bold mb-4">{!! $event->status ? "Published" : "Draft" !!}</p>
                      <!-- Add to cart button -->

                      <p class="text-2 font-bold mb-4">List of user:</p>
                      <ul class="">
                        @if($event->enrollments)
                          @foreach($event->enrollments as $user)
                            <li>{{ $user->user->name }} : {{ $user->user->roles->first()->title }}</li>
                          @endforeach
                        @else
                          <li> Not User Enrolled yet </li>
                        @endif
                      </ul>
                      
                  </div>
                </div>
            </div>
              
        </div>
    </div>
</div>
