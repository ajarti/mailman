<?php

namespace App\Jobs;

use App\Models\Email;

class ProcessEmail extends Job
{

    protected $email;


    /**
     * Create a new ProcessEmail instance.
     *
     * @param  Email  $email
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Process email ...
    }
}
