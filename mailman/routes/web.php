<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$router->get('/', function (\Illuminate\Http\Request $request) use ($router) {

    $email = 'testmail-'.mt_rand(1000,10000);
    $job   = new \App\Jobs\ProcessEmail($email);
    try {
        Illuminate\Support\Facades\Queue::push($job);
    } catch (\Exception $e) {
        dd($e);
    }

    return 'done';
});

$router->get('/container-id', function () use ($router) {

    return exec('cat /proc/1/cpuset | cut -c9-');

});
