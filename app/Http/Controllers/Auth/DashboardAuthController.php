<?php

namespace App\Http\Controllers;

use App\Models\Event;

class DashboardAuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $events = Event::with('location', 'tags')->orderBy('created_at', 'desc')->paginate(12);
        return view('dashboard',compact('events'));
    }
}
