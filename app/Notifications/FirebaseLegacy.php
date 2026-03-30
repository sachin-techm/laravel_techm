<?php

namespace App\Notifications;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FirebaseLegacy
{
    
    public static function send($to, $message, $title = "App Notification", $image = NULL, $data = NULL, $sound = null, $android_channel_id = null) 
    {   

        $fields = [];
        $fields['notification'] = ['body' => $message, 'title' => $title];

        if(is_array($to)){

            $fields['registration_ids'] = $to;

        } else {

            $fields['to'] = $to;
        }

        if(!empty($sound))
        {
        	$fields['notification']['sound'] = $sound;
        }
        if(!empty($android_channel_id))
        {
        	$fields['notification']['android_channel_id'] = $android_channel_id;
        }

        if(isset($image) && !empty($image))
        {
            $fields['notification']['image'] = $image;
        }

        if(isset($data) && !empty($data))
        {
            $fields['data'] = $data;
        }

        $fields['content_available'] = true;
        $fields['priority'] = 'high';
        
        // dd($fields);die;
        return self::sendPushNotification($fields);
    }

    // Sending message to a topic by topic name
    public static function sendToTopic($to, $message) {
        $fields = array(
            'to' => '/topics/' . $to,
            'notification' => ['message' => $message, 'title' => $message]
        );
        return $this->sendPushNotification($fields);
    }

    // sending push message to multiple users by firebase registration ids
    public static function sendMultiple($registration_ids, $message) {
        $fields = array(
            'to' => $registration_ids,
            'notification' => ['message' => $message,'title' => $message]
        );

        return $this->sendPushNotification($fields);
    }
    
    // function makes curl request to firebase servers
    private static function sendPushNotification($fields) {
        
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';

        $headers = array(
            'Authorization:key=' . env('FIREBASE_SERVER_KEY', ''),
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        

        if ($result === FALSE) {
            // die('Curl failed: ' . curl_error($ch));
            \Log::info('sendPushNotification Curl failed==>' . curl_error($ch));
            return ['status' => false, 'message' => curl_error($ch)];
        }

        // Close connection
        curl_close($ch);
        $result = json_decode($result, true);

        if( is_array($result) && isset($result['success']) && $result['success'] >= 1){
            return ['status' => true, 'message' => 'Notification sent'];
        }

        // dd($result);
        return ['status' => false, 'message' => @$result['results'][0]['error'] ?? 'Curl error'];
    }
    
}
