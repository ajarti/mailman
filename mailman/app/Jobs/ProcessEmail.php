<?php

namespace App\Jobs;

use App\Contracts\MailService;
use App\Models\Email;
use SendGrid;
use SendGrid\Mail\Mail;

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
     * @throws SendGrid\Mail\TypeException
     */
    public function handle(MailService $mailService)
    {
        $email = new Mail();
        $email->setFrom($this->email->from_email, $this->email->from_name);
        $email->setSubject($this->email->subject);
        $email->addTo($this->email->to_email, $this->email->to_name);
        $email->addContent("text/plain", $this->email->text);
        $email->addContent("text/html", $this->email->html);
        $email->addCustomArg('custom_id', $this->email->custom_id);
        $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode()."\n";
            print_r($response->headers());
            print $response->body()."\n";
        } catch (Exception $e) {
            echo 'Caught exception: '.$e->getMessage()."\n";
        }
    }
}
