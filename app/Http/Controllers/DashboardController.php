<?php

namespace App\Http\Controllers;

use App\Models\Event;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with upcoming events.
     */
    public function index()
    {
        $events = Event::with('location', 'tags')
                       ->where('start_date', '>=', today())
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('dashboard', compact('events'));
    }
}
