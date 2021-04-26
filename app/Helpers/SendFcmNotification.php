<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class SendFcmNotification
{

    public function send($data, $androidDevices)
    {
        Log::info('test');
        /*
        "data" => [
        "ANYTHING EXTRA HERE" => "Demo"
        ],
         */

        $json_data = [
            "registration_ids" => $androidDevices,
            "notification" => [
                "body" => $data['content'],
                "title" => $data['title'],
                "icon" => "ic_notification",
            ],
            "data" => [
                "message" => $data['content'],
                "title" => $data['title'],
                "type" => isset($data['type']) ? $data['type'] : 0,
                "data" => (isset($data) && isset($data['data_ob']) && $data['data_ob']) ? $data['data_ob'] : '',
            ],
        ];

        // "data" => ["payload" => ["message" => $data['content']]]

        //api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = 'AAAAIikccLI:APA91bGwyYz2SZlEwe0lGp6fKWQ4VcqMaivSyNA0WLZ320L-okuC_F7G92PSvJhXgN0dweXasN22XFKlghj5eArIJzGXKw7w_goMu3SeXkOgblZTDzZ9-QimFnZLzcVSebXGDauFAuUE';
        //header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key,
        );

        $message = json_encode($json_data);

        // FCM
        $url = 'https://fcm.googleapis.com/fcm/send'; // FCM API end-point
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
        $result = curl_exec($ch);
        Log::info($result, $androidDevices);
        if ($result === false) {
            Log::info(["SendFcmNotification => send => CURL Error:"]);
            Log::info([curl_error($ch)]);
            //die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
    }
}
