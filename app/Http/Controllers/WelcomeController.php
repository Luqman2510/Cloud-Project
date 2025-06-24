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
        $events = collect([]);

        try {
            // Check if database connection is working
            \DB::connection()->getPdo();
            \Log::info('Database connection successful');

            // Check if events table exists
            if (!\Schema::hasTable('events')) {
                \Log::warning('Events table does not exist - running with empty events');
            } else {
                \Log::info('Events table exists - fetching events');
                $events = Event::with('location', 'tags')
                    ->where('start_date', '>=', today())
                    ->orderBy('created_at', 'desc')
                    ->get();
                \Log::info('Found ' . $events->count() . ' events');
            }
        } catch (\Exception $e) {
            // If any database error, return empty events array and log the error
            \Log::error('Database error in WelcomeController: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return view('welcome', compact('events'));
    }
}
