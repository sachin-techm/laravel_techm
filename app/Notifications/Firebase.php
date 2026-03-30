<?php

namespace App\Notifications;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Kreait\Firebase\Factory;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\AndroidConfig;

class Firebase
{
    
    public $factory;
    public $messaging;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $factory = $factory->withAuthTokenCache(new FilesystemCache());
        $this->factory = (new Factory)->withServiceAccount(storage_path('/firebase/kshetrapati-app-firebase-adminsdk-1vcxr-d1140cf167.json'));
        $this->messaging = $this->factory->createMessaging();
    }

    /**
     * Compose firebase push notification message
     * @param $to
     * @param $message
     * @param $title
     * @param $image
     * @param $data
     * @param $sound
     * @param $android_channel_id
     * @return array
     */
    public function send($to, $message, $title = "App Notification", $customData = NULL, $platformConfig = null) 
    {

        $data           = [];
        $deviceToken    = '';
        $topic          = '';
        $deviceTokens   = [];
        $notification   = [
                            'body' => $message, 
                            'title' => $title
                        ];

        if(is_array($to)){

            $deviceTokens = $to;

        } elseif(strlen($to) > 25) {

            $deviceToken = $to;

        } else {
            
            $topic = $to;
        }

        if(!empty($deviceToken)) {

            return $this->sendToToken($deviceToken, $notification, $customData, $platformConfig);

        } else if(!empty($topic)) {

            return $this->sendToTopic($topic, $notification, $customData, $platformConfig);

        } else {

            return $this->sendMultiple($deviceTokens, $notification, $customData, $platformConfig);
        }
        
    }
    
    /**
     * Send firebase push notification message to token
     * @param $deviceToken
     * @param $notification
     * @param $data
     * @return array
     */
    private function sendToToken($deviceToken, $notification, $data = [], $platformConfig = []) {
        
        $message = CloudMessage::withTarget('token', $deviceToken)
            // ->withNotification(Notification::create('Title', 'Body'))
            ->withNotification($notification)
            ->withData($data);

        $ios = false;
        if($ios) { 

            $config = ApnsConfig::fromArray([
                'headers' => [
                    'apns-priority' => '10',
                ],
                'payload' => [
                    'aps' => [
                        'alert' => [
                            'title' => $notification['title'],
                            'body' => $notification['body'],
                        ],
                        'badge' => 42,
                        'sound' => $platformConfig['sound'] ?? 'default',
                        'content-available' => $platformConfig['content_available'] ?? 0,
                    ],
                ],
                'fcm_options' => [
                    'image' => $platformConfig['image'] ?? NULL,
                ]
            ]);

            $message = $message->withApnsConfig($config);

        } else {

            $config = AndroidConfig::fromArray([
                'ttl' => '3600s',
                'priority' => $platformConfig['priority'] ?? 'high',
                'notification' => [
                    'title' => $notification['title'],
                    'body' => $notification['body'],
                    'icon' => $platformConfig['icon'] ?? 'ic_stat_notification_icon',
                    'color' => $platformConfig['color'] ?? '#f45342',
                    'sound' => $platformConfig['sound'] ?? 'default',
                    'image' => $platformConfig['image'] ?? NULL,
                ],
            ]);
            $message = $message->withAndroidConfig($config);
        }

        try {

            $report = $this->messaging->send($message);

            return ['status' => true, 'message' => 'Notification sent'];

        } catch (MessagingException $e) {
            
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send firebase push notification message to mulitple tokens
     * @param $deviceTokens
     * @param $notification
     * @param $data
     * @return array
     */
    private function sendMultiple($deviceTokens, $notification, $data = [], $platformConfig = []) {

        $message = CloudMessage::new()
            ->withNotification($notification)
            ->withData($data);

            // $message = CloudMessage::fromArray($notification)
            // ->withData($data);

        try {

            $report = $this->messaging->sendMulticast($message, $deviceTokens);

            if ($report->hasFailures()) {

                $errors = $this->compileErrorMessages($report);

                // dd($errors);

                return ['status' => false, 'message' => $errors[0] ?? 'Unknown error', 'errors' => $errors];
            }

            return ['status' => true, 'message' => 'Notification sent'];

        } catch (MessagingException $e) {
            
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send firebase push notification message to topic
     * @param $topic
     * @param $notification
     * @param $data
     * @return array
     */
    private function sendToTopic($topic, $notification, $data = [], $platformConfig = []) {
        
        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData($data);
            
        try {

            $report = $this->messaging->send($message);

            return ['status' => true, 'message' => 'Notification sent'];

        } catch (MessagingException $e) {

            return ['status' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send firebase push notification message to topic
     * @param $deviceToken
     * @param $notification
     * @param $data
     * @return void
     */
    private function compileErrorMessages($report) {

        $errors = [];

        if ($report->hasFailures()) {
            foreach ($report->failures()->getItems() as $failure) {
                $errors[] = $failure->error()->getMessage().PHP_EOL;
            }
        }

        return $errors;
    }
    
}
