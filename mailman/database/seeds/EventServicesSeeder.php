<?php

use Illuminate\Database\Seeder;


class EventServicesSeeder extends Seeder
{
    public function run()
    {
        // Only if empty.
        if (DB::table('event_service')->count()) return;

        DB::table('event_service')->insert([

            // Mailjet
            ['event_id' => 1, 'service_id' => 1, 'event' => 'queued'],
            ['event_id' => 2, 'service_id' => 1, 'event' => 'pushed'],
            ['event_id' => 3, 'service_id' => 1, 'event' => 'deferred'],
            ['event_id' => 4, 'service_id' => 1, 'event' => 'sent'],
            ['event_id' => 5, 'service_id' => 1, 'event' => 'open'],
            ['event_id' => 6, 'service_id' => 1, 'event' => 'click'],
            ['event_id' => 7, 'service_id' => 1, 'event' => 'bounce'],
            ['event_id' => 8, 'service_id' => 1, 'event' => 'spam'],
            ['event_id' => 9, 'service_id' => 1, 'event' => 'blocked'],
            ['event_id' => 10, 'service_id' => 1, 'event' => 'unsub'],

            // Sendgrid
            ['event_id' => 1, 'service_id' => 2, 'event' => 'queued'],
            ['event_id' => 2, 'service_id' => 2, 'event' => 'processed'],
            ['event_id' => 3, 'service_id' => 2, 'event' => 'deferred'],
            ['event_id' => 4, 'service_id' => 2, 'event' => 'delivered'],
            ['event_id' => 5, 'service_id' => 2, 'event' => 'open'],
            ['event_id' => 6, 'service_id' => 2, 'event' => 'click'],
            ['event_id' => 7, 'service_id' => 2, 'event' => 'bounce'],
            ['event_id' => 8, 'service_id' => 2, 'event' => 'spamreport'],
            ['event_id' => 9, 'service_id' => 2, 'event' => 'dropped'],
            ['event_id' => 10, 'service_id' => 2, 'event' => 'unsubscribe'],
        ]);
    }
}
