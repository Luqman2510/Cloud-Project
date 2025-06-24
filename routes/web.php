<?php

use App\Http\Controllers\AttendingEventController;
use App\Http\Controllers\AttentingSystemController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventIndexController;
use App\Http\Controllers\EventShowController;
use App\Http\Controllers\LikedEventController;
use App\Http\Controllers\LikeSystemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SavedEventController;
use App\Http\Controllers\SavedEventSystemController;
use App\Http\Controllers\TestEventController;
use App\Http\Controllers\WelcomeController;
use App\Models\Location;
use App\Models\Event;
use Illuminate\Support\Facades\Route;


// Test route to check if Laravel is working
Route::get('/test', function () {
    return 'Laravel is working perfectly on Google Cloud Run with GitHub Actions CI/CD! 🚀';
});

// Debug route to test database
Route::get('/debug', function () {
    try {
        $dbPath = database_path('database.sqlite');
        $dbExists = file_exists($dbPath);
        $dbReadable = is_readable($dbPath);
        $dbWritable = is_writable($dbPath);

        $info = [
            'database_path' => $dbPath,
            'database_exists' => $dbExists,
            'database_readable' => $dbReadable,
            'database_writable' => $dbWritable,
            'database_size' => $dbExists ? filesize($dbPath) : 0,
        ];

        // Test database connection
        try {
            DB::connection()->getPdo();
            $info['connection'] = 'SUCCESS';
        } catch (Exception $e) {
            $info['connection'] = 'FAILED: ' . $e->getMessage();
        }

        // Test if tables exist
        try {
            $info['events_table_exists'] = Schema::hasTable('events');
            $info['locations_table_exists'] = Schema::hasTable('locations');
            $info['tags_table_exists'] = Schema::hasTable('tags');
        } catch (Exception $e) {
            $info['table_check'] = 'FAILED: ' . $e->getMessage();
        }

        return response()->json($info, 200, [], JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500, [], JSON_PRETTY_PRINT);
    }
});

// Fixed homepage with proper layout component
Route::get('/', function () {
    return view('welcome', ['events' => collect([])]);
})->name('welcome');

// Original route (commented out for debugging)
// Route::get('/', WelcomeController::class)->name('welcome');
Route::get('/e', EventIndexController::class)->name('eventIndex');
Route::get('/e/{id}', EventShowController::class)->name('eventShow');
// Define the route for showing the event details
//Route::get('/events/{id}', [EventController::class, 'show'])->name('eventShow');
//Route::get('events/{id}', [EventShowController::class, '__invoke']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource route for events
    Route::resource('/events', EventController::class);

    Route::get('/dashboard', function (EventIndexController $controller) {
        $events = $controller->fetchEvents();
        return view('dashboard', compact('events'));
    })->middleware(['auth', 'verified'])->name('dashboard');
    
    Route::get('/dashboard', [EventController::class, 'dashboard'])->name('dashboard');


    Route::get('/locations/{location}', function (Location $location) {
        return response()->json($location->places);
    });
    
    //Route::get('/events/{id}', [EventController::class, 'show'])->name('eventShow');
    Route::get('/liked-events', LikedEventController::class)->name('likedEvents');
    Route::get('/saved-events', SavedEventController::class)->name('savedEvents');
    Route::get('/attendind-events', AttendingEventController::class)->name('attendingEvents');
    Route::post('/events-like/{id}', LikeSystemController::class)->name('events.like');
    Route::post('/events-saved/{id}', SavedEventSystemController::class)->name('events.saved');
    Route::post('/events-attending/{id}', AttentingSystemController::class)->name('events.attending');

});

require __DIR__ . '/auth.php';
