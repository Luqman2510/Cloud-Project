<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $events = Event::with('location', 'tags')->orderBy('created_at', 'desc')->paginate(12);
        return view('eventIndex', compact('events'));
    }


    public function fetchEvents()
    {
        // Fetch events with location and tags, and order them by the most recent
        return Event::with('location', 'tags')->orderBy('created_at', 'desc')->paginate(12);
    }
}
