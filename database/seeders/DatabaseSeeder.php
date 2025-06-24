<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Place;
use App\Models\Location;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
        
        User::factory()->create([
            'name' => 'Student',
            'email' => 'student@example.com',
            'is_admin' => false,
        ]);
        

        Location::create(['name' => 'Faculty KPPIM']);
        Location::create(['name' => 'Other Faculty']);
        Place::create(['location_id' => 1, 'name' => 'Dewan Al-Ghazali,CS1']);
        Place::create(['location_id' => 1, 'name' => 'DK1,CS2']);
        Place::create(['location_id' => 1, 'name' => 'MK15,CS2']);
        Place::create(['location_id' => 2, 'name' => 'Dewan Seminar 1']);
        Place::create(['location_id' => 2, 'name' => 'Dewan Utama']);
        Place::create(['location_id' => 2, 'name' => 'Bilik Mesyuarat 1']);

        Tag::create(['name' => 'Undergraduate', 'slug' => 'undergraduate']);
        Tag::create(['name' => 'Postgraduate', 'slug' => 'postgraduate']);
        Tag::create(['name' => 'Open to All', 'slug' => 'open-to-all']);
    }
}
