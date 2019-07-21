<?php

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class ServicesSeeder extends Seeder
{
    public function run()
    {
        // Only if empty.
        if (Service::count()) return;

        Service::insert([
            ['id' => 1, 'name' => 'Mailgun', 'slug' => 'mailgun', 'order' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Sendgrid', 'slug' => 'sendgrid', 'order' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
