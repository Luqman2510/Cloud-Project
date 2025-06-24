<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Location;
use App\Models\Event;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function __construct()
    {
        // Ensure only admins can access these methods
        $this->middleware('can:is_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $events = Event::with('Location')->get();
        return view('events.index', compact('events'));
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        // Check if the user has liked the event
        $like = auth()->user() ? $event->likes()->where('user_id', auth()->id())->exists() : false;
    
        // Check if the user has saved the event
        $savedEvent = auth()->user() ? $event->savedEvents()->where('user_id', auth()->id())->exists() : false;
    
        // Check if the user is attending the event
        $attending = auth()->user() ? $event->attendings()->where('user_id', auth()->id())->exists() : false;
    
        return view('eventsShow', compact('event', 'like', 'savedEvent', 'attending'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $locations = Location::all();
        $tags = Tag::all();
        return view('events.create', compact('locations', 'tags'));
    }

    public function dashboard(): View
    {
    // Fetch all events
        $events = Event::with(['tags', 'location'])->get();

    // Fetch the latest 5 upcoming events based on start_date
        $latestEvents = Event::with(['tags', 'location'])
        ->where('start_date', '>', now()) // Ensure only future events
        ->orderBy('start_date', 'asc')   // Order by closest upcoming date
        ->take(5)
        ->get();

        return view('dashboard', [
        'events' => $events,
        'latestEvents' => $latestEvents,
        ]);
    }

    


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEventRequest $request): RedirectResponse
    {
        if ($request->hasFile('image')) {

            $data = $request->validated();
            $data['image'] = $request->file('image')->store('events', 'public');
            $data['user_id'] = auth()->id();
            $data['slug'] = Str::slug($request->title);

            $event = Event::create($data);
            $event->tags()->attach($request->tags);
            return to_route('events.index');
        } else {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View
    {
        $locations = Location::all();
        $tags = Tag::all();
        return view('events.edit', compact('locations', 'tags', 'event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
        
            // Save the new image in the 'public/events' directory
            $data['image'] = $request->file('image')->store('events', 'public');
        }
        $event->update($data);

        $data['slug'] = Str::slug($request->title);
        $event->update($data);
        $event->tags()->sync($request->tags);
        return to_route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        Storage::delete($event->image);
        $event->tags()->detach();
        $event->delete();
        return to_route('events.index');
    }
}
