<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Pushok\AuthProvider;
use Pushok\Client;
use Pushok\Notification;
use Pushok\Payload;
use Pushok\Payload\Alert;

class SendIosNotification
{
    public function send($data, $iosDevices)
    {
        Log::info(["SendIosNotification => send => Device Tokens:"]);
        Log::info([$iosDevices]);
        Log::info([$data]);

        $options = [
            'key_id' => 'DN42K6GHTV', // The Key ID obtained from Apple developer account
            'team_id' => 'X2899W8P7Q', // The Team ID obtained from Apple developer account
            'app_bundle_id' => 'com.jobflowios', // The bundle ID for app obtained from Apple developer account
            'private_key_path' => __DIR__ . '/AuthKey_DN42K6GHTV.p8', // Path to private key
            'private_key_secret' => null, // Private key secret
        ];

        $authProvider = AuthProvider\Token::create($options);
        $title = $data['title'];
        $content = $data['content'];
        $alert = Alert::create()->setTitle($title);
        $alert = $alert->setBody($content);

        $payload = Payload::create()->setAlert($alert);

        //set notification sound to default
        $payload->setSound('default');

        //add custom value to your notification, needs to be customized
        $payload->setCustomValue('message', $content);
        $payload->setCustomValue('title', $title);
        $payload->setCustomValue('type', isset($data['type']) ? $data['type'] : 0);
        $payload->setCustomValue('data', (isset($data) && isset($data['data_ob']) && $data['data_ob']) ? $data['data_ob'] : '');

        $deviceTokens = $iosDevices;

        $notifications = [];
        foreach ($deviceTokens as $deviceToken) {
            $notifications[] = new Notification($payload, $deviceToken);
        }

        $client = new Client($authProvider, $production = true);
        $client->addNotifications($notifications);

        $responses = $client->push(); // returns an array of ApnsResponseInterface (one Response per Notification)

        Log::info(["SendApnsNotification => send:"]);
        die($responses);
        Log::info($responses);

        // foreach ($responses as $response) {
        //     $response->getApnsId();
        //     $response->getStatusCode();
        //     $response->getReasonPhrase();
        //     $response->getErrorReason();
        //     $response->getErrorDescription();
        // }
    }
}
