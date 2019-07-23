<?php

namespace App\Http\Controllers;

use App\Models\Service;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class WebhookController
 *
 * @package App\Http\Controllers
 */
class WebhookController extends Controller
{

    public function process($serviceSlug = '', Request $request)
    {
        // Build the mapping array,
        $eventMap = Cache::remember('eventMap', 6000, function () {
            $events  = [];
            $service = Service::with(['events'])->whereSlug('sendgrid')->first();
            if (is_a($service, Service::class) && isset($service->events) && is_a($service->events, Collection::class)) {
                $events = array_map(function ($eventItem) {
                    return [$eventItem['pivot']['event'] => $eventItem['id']];
                }, $service->events->toArray());
            }
            return $events;
        });

        // Decode the payload.
        $events = json_decode($request->getContent(), true) ?? [];

        // Process events.
        if (is_array($events)) {
            foreach ($events as $event) {
                $eventId = $eventMap[$event['event']] ?? 0;
                Log::info('CustomId: '.$event['custom_id'].' - '.$event['event'].' - '.$eventId);
            }
        }

        return;
    }


    /**
     * Update the callback URL in the remote services.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {

        // Validate we have a Webhook url.
        $this->validate($request, [
            'callback_url' => 'required|url',
        ]);

        // Update the service.
        try {
            $newCallback = $request->get('callback_url').'/api/callback/sendgrid';
            $client      = new Client(['base_uri' => 'https://api.sendgrid.com']);
            $response    = $client->request(
                'PATCH',
                '/v3/user/webhooks/event/settings',
                [
                    'headers' => [
                        'Authorization' => 'Bearer '.env('SENDGRID_API_KEY'),
                        'Accept'        => 'application/json',
                    ],
                    'json'    => [
                        'url' => $newCallback
                    ],
                ]);

            // Check the returned URL is the same as the one we sent.
            $webhookDetails = json_decode((string)$response->getBody(), true) ?? null;
            if (isset($webhookDetails['url']) && ($webhookDetails['url'] == $newCallback)) {
                return response()->json(['status' => 'success']);
            }

        } catch (\Exception $e) {

            return response()->json([
                'status'  => 'error',
                'message' => 'Updating the callback URL failed, please contact support.',
                'error'   => $e->getMessage() ?? 'No error message was found.'
            ], 424);

        }

        // Something filed!
        return response()->json([
            'status'  => 'error',
            'message' => 'Updating the callback URL failed, please contact support.',
            'error'   => 'An unexpected error occurred.'
        ], 424);

    }

}
