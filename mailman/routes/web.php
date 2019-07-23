<?php

/*
 * Admin Routes - Loads the Vue Interface,
 */
$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('/', function () {
        return view('app');
    });
});

/*
 * CORS Enabled Routes.
 */
$router->group(['prefix' => 'api', 'middleware' => 'cors'], function () use ($router) {

    // The endpoint for processing webhook callbacks.
    $router->post('/callback/{service}', 'WebhookController@process');

    // The endpoint for receiving emails.
    $router->post('/queue-mail', 'QueueMailController@store');

    // List available services.
    $router->get('/services', 'ServiceController@index');

    // The endpoint to allow the client to update the services with the current ngrok tunnel.
    $router->post('/webhook', 'WebhookController@update');

});


$router->get('/', function (\Illuminate\Http\Request $request) use ($router) {


    return 'Done ..';

});


/*
 * Can be called to show that the load balancing is working.
 * The containers ID is returned.
 */
$router->get('/container-id', function () use ($router) {
    return exec('cat /proc/1/cpuset | cut -c9-');
});
