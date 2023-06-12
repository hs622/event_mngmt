<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Event;
use App\Models\Enroll;
use App\Models\Country;
use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Events extends Component
{
    public $modalFormVisible = false;
    public $enrolledModal = false;
    public $deleteModal = false;

    public $deleteSelectedEvent;
    public $eventId;
    public $cities = [];
    public $event = [
        'title' => '',
        'slug' => '',
        'description'   => '',
        'status'   => '',
        'schedule' => [
            'country_id' => '',
            'city_id' => '',
            'venue' => '',
            'start_at'  => '',
            'end_at'  => ''
        ]
    ];
    
    public function render()
    {
        return view('livewire.events', [
            'events'    => Event::whereNotIn('id', auth()->user()->events->pluck('event_id'))->get(),
            'countries' => Country::where('status', 1)->get(),
            'cities' => $this->cities,
        ]);
    }

    protected $rules = [
        'event' => 'required|array',
        'event.title' => 'required|string',
        'event.description' => 'required|min:15',
        'event.schedule.country_id' => 'required|integer',
        'event.schedule.city_id' => 'required|integer',
        'event.schedule.venue' => 'required|string',
        'event.schedule.start_at' => 'required|date|after:today',
        'event.schedule.end_at' => 'required|date|after:event.startAt',
    ];

    protected $messages = [
        'event.title' => 'Enter the title of your event.',
        'event.description' => 'Please describe about the event.',
        'event.schedule.country_id' => 'In which country event is to be held?',
        'event.schedule.city_id' => 'In which city event is to be held?',
        'event.schedule.venue' => 'Enter the name of the place.',
        'event.schedule.start_at.after' => 'The start date must be a date after today.',
        'event.schedule.end_at.after' => 'The start end must be a date after start.'
    ];

    public function createShowModal() {
        $this->resetValidation();
        $this->reset();
        $this->modalFormVisible = true;
    }

    public function updateShowModal(Int $id) {
        $this->eventId = $id;
        $this->event = Event::where('id', $id)->with('schedule')->first()->toArray();
        $this->cities = City::where('country_id', $this->event['schedule']['country_id'])
            ->get()
            ->pluck('name', 'id');
        $this->modalFormVisible = true;
    }

    public function updatedEventScheduleCountryId(int $countryId) {
        $this->cities = City::where('status', 1)
            ->where('country_id', $countryId)
            ->get()
            ->pluck('name', 'id');
    }

    public function store() {
        $this->validate();

        $event = Event::create([
            'title'         => $this->event['title'],
            'slug'          => Str::slug($this->event['title']) ,
            'description'   => $this->event['description'],
            'status'        => $this->event['status'] ? 1 : 0
        ]);

        $event->schedule()->create($this->event['schedule']);

        $this->reset();
        $this->modalFormVisible = false;
        session()->flash('message', 'Event created successfully.');
    }

    public function update() {
        $this->validate();

        $event = Event::find($this->event['id']);
        $eventUpdated = $event->update([
            'title'         => $this->event['title'],
            'slug'          => Str::slug($this->event['title']) ,
            'description'   => $this->event['description'],
            'status'        => $this->event['status'] ? 1 : 0
        ]);

        unset($this->event['schedule']['created_at']);
        unset($this->event['schedule']['updated_at']);
        unset($this->event['schedule']['deleted_at']);

        $scheduleUpdated = $event->schedule()->update($this->event['schedule']);
        $this->reset();
        $this->modalFormVisible = false;
        session()->flash('message', 'Event updated successfully.');
    }

    public function deleteShowModal($eventId) {
        $this->deleteSelectedEvent = Event::find($eventId);
        $this->deleteModal = true;
    }

    public function deleteConfirmed() {
        Schedule::where('event_id', $this->deleteSelectedEvent->id)->delete();
        Event::find($this->deleteSelectedEvent->id)->delete();
        $this->deleteModal = false;
    }

    public function enrolledInEvent(int $eventId) {
        Enroll::create([
            'user_id'   => auth()->user()->id,
            'event_id'  => $eventId,
        ]);    
        $this->enrolledModal = true;
    }
}
