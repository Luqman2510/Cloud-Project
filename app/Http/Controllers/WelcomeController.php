<?php

namespace App\Http\Controllers;

use App\Models\Event;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            // Check if database connection is working
            \DB::connection()->getPdo();

            // Check if events table exists
            if (!\Schema::hasTable('events')) {
                \Log::warning('Events table does not exist');
                $events = collect([]);
            } else {
                $events = Event::with('location', 'tags')
                    ->where('start_date', '>=', today())
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        } catch (\Exception $e) {
            // If any database error, return empty events array and log the error
            \Log::error('Database error in WelcomeController: ' . $e->getMessage());
            $events = collect([]);
        }

        return view('welcome', compact('events'));
    }
}
