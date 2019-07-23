<?php

namespace App\Contracts;

interface MailService
{

    /**
     * Sets the from address for the email.
     *
     * @param  string  $from
     *
     * @return boolean
     */
    public function from(string $from = '');


    /**
     * Sets the replyTo address for the email, will revert to 'from' address if blank.
     *
     * @param  string  $replyTo
     *
     * @return boolean
     */
    public function replyTo(string $replyTo = '');


    /**
     *
     * Sets the content for HTML portion of the email.
     *
     * @param  string  $html
     *
     * @return void
     */
    public function html(string $html = '');


    /**
     *
     * Sets the content using Markdown, will be converted to HTML.
     *
     * @param  string  $markdown
     *
     * @return void
     */
    public function markdown(string $markdown = '');


    /**
     *
     * Sets the mail priority from 1 - high, 3 - normal, 5 - low.
     *
     * @param  int  $priority
     *
     * @return void
     */
    public function priority(int $priority = 3);


    /**
     *
     * Sends the email.
     *
     * @return int  The index of the email in the DB log.
     */
    public function send();


    /**
     *
     * Sets the subject for the email.
     *
     * @param  string  $subject
     *
     * @return void
     */
    public function subject(string $subject = '');


    /**
     *
     * Sets the content for raw text portion of the email.
     *
     * @param  string  $text
     *
     * @return void
     */
    public function text(string $text = '');


    /**
     * Sets the contacts that should receive this mail directly, either a single email or an array of contacts.
     *
     * @param  mixed  $contacts
     *
     * @return boolean
     */
    public function to($contacts);


}
