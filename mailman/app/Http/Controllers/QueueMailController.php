<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmail;
use App\Models\Email;
use Illuminate\Http\Request;

/**
 * Class QueueMailController
 *
 * @package App\Http\Controllers
 */
class QueueMailController extends Controller
{


    /**
     * @param  Request  $request
     * @param  Email  $email
     */
    public function store(Request $request, Email $email)
    {
        // Currently the html is automatically converted to Markdown on the client,
        // but I would use a lib like parsedown to do the conversion serverside.
        // parsedown(str_replace('\n', "<br>".PHP_EOL, $request->get('markdown')));

        // Build up the insert data.
        $data = array_merge($request->only([
            'client_id',
            'from_email',
            'from_name',
            'html',
            'markdown',
            'priority',
            'subject',
            'text',
            'to_email',
            'to_name',
        ]),
            [
                'custom_id' => preg_replace("/[^a-zA-Z0-9]/", "", uniqid(microtime(), true))
            ]
        );

        // Save the message/email to the DB.
        $newMail = $email->create($data);
        $job     = new ProcessEmail($newMail);
        try {
            dispatch($job);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Queueing this message for distribution failed, please contact support.',
                'error'   => $e->getMessage() ?? 'No error message was found.'
            ], 424);
        }

        // All ok!
        return response()->json(['status' => 'success']);

    }


}
