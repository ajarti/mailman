<?php

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class EventsSeeder extends Seeder
{
    public function run()
    {
        // Only if empty.
        if (Event::count()) return;

        Event::insert([
            ['id' => 1, 'name' => 'queued', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'pushed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'deferred', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'sent', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'opened', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'clicked', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'bounced', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'reported', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],  // Spam
            ['id' => 9, 'name' => 'blocked', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],   // Dropped
            ['id' => 10, 'name' => 'unsubscribed', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
