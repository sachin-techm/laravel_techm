<?php

namespace App\Notifications;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\Firebase;
use App\Models\User;
use App\Models\PushNotification as PushNotificationModel;
use App\Models\Result;
use App\Models\Notification;
use App\Models\Order;

class FCMPushNotification
{

    /**
     * Send & save test notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function testNotification($request) 
    {
        if(isset($request->firebase_token) && !empty($request->firebase_token)) {
           
            $firebase_token 	= $request->firebase_token;
            $title 				= 'Test Notification Title';
            $message 			= 'This is test notification body';

            // $customData = ['TYPE' => "PARENT", 'PAGE_NAME' => 'MyChild', 'PARAMS' => ['id' => $request->id ?? 0, 'referer' => 'PushNotification']];

            $image = 'https://cdn.pixabay.com/photo/2023/09/10/00/49/lovebird-8244066_1280.jpg';
            $sound = 'default';
            $android_channel_id = 'android_channel_id';
            
            $platformConfig = [
                'image' => $image,
                'sound' => $sound,
                'icon' => 'notification_icon',
                'android_channel_id' => $android_channel_id,
                'content_available' => 1,
                'priority' => 'high',
            ];

            $customData = [
                        'TYPE' => "PARENT", 
                        'PAGE_NAME' => 'Notification', 
                        'PARAMS' => json_encode(
                            [
                                'id' => $request->id ?? 0, 
                                'referer' => 'PushNotification'
                            ]
                        )
                    ];
            
            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);

            if(isset($response['status']) && $response['status']){
                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);
        }

        return response()->json(['status' => false, 'data' => null, 'message' => 'Token Not Found!'], 200);
    }

    /**
     * Send notification from admin manual module
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendNotification(PushNotificationModel $notification) 
    {
        
        try {
       
            $firebase_token     = null;
            $title              = $notification->title;
            $message            = $notification->body;
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'             => $sound,
                'icon'              => 'notification_icon',
                'content_available' => 1,
                'priority'          => 'high',
            ];

            if(!empty($notification->image)) {
                $platformConfig['image'] = asset('uploads/push_notifications/'.$notification->image);
            }

            if(!empty($notification->channel)) {
                $platformConfig['android_channel_id'] = $notification->channel;
            }

            if(!empty($notification->topic)) {

                // For topic
                $firebase_token = $notification->topic;

            } else if($notification->all_users == 1) {

                // For all users
                $firebase_token = User::where('firebase_token', '<>', NULL)->pluck('firebase_token')->toArray();
                
            } else {

                $firebase_token = User::whereIn('id', $notification->user_ids)->pluck('firebase_token')->toArray();
            }

            $customData = [
                'TYPE'      => "BACKEND", 
                'PAGE_NAME' => 'Notification', 
                'PARAMS'    => json_encode([
                    'id'        => 0,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Send & save result submit notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendResultNotification(Result $result) 
    {
        
        try {
        
            $user   = User::find($result->user_id);
            
            if(empty($user) || empty($user->firebase_token)) {
                return false;
            }

            $firebase_token     = $user->firebase_token;
            $title              = "Test submitted";
            $message            = "Your test (".($result->questionSet->set_name ?? 'N/A').") has been submitted successfully.";
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'                 => $sound,
                'icon'                  => 'notification_icon',
                'content_available'     => 1,
                'priority'              => 'high',
                'android_channel_id'    => 'android_channel_id',
            ];

            $customData = [
                'TYPE'      => "BACKEND", 
                'PAGE_NAME' => 'MyTestResults', 
                'PARAMS'    => json_encode([
                    'id'        => $result->id,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $meta = [
                'title' => $title,
                'message' => $message,
                'sound' => $sound,
                'platformConfig' => $platformConfig,
                'customData' => $customData,
            ];

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->type = "TEST";
            $notification->action_id = $result->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->meta = json_encode($meta);
            $notification->save();

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Send & save result submit notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendCoursePurchaseNotification(Order $order) 
    {
        
        try {
        
            $user   = User::find($order->user_id);
            
            if(empty($user) || empty($user->firebase_token)) {
                return false;
            }

            $firebase_token     = $user->firebase_token;
            $title              = "Course purchased";
            $message            = "You have successfully purchased course (".($order->course->course_name ?? 'N/A').").";
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'                 => $sound,
                'icon'                  => 'notification_icon',
                'content_available'     => 1,
                'priority'              => 'high',
                'android_channel_id'    => 'android_channel_id',
            ];

            $customData = [
                'TYPE'      => "SYSTEM", 
                'PAGE_NAME' => 'MyCourseDetails', 
                'PARAMS'    => json_encode([
                    'id'        => $order->id,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $meta = [
                'title' => $title,
                'message' => $message,
                'sound' => $sound,
                'platformConfig' => $platformConfig,
                'customData' => $customData,
            ];

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->type = "COURSE";
            $notification->action_id = $order->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->meta = json_encode($meta);
            $notification->save();

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Send & save result submit notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendTestPurchaseNotification(Order $order) 
    {
        
        try {
        
            $user   = User::find($order->user_id);
            
            if(empty($user) || empty($user->firebase_token)) {
                return false;
            }

            $firebase_token     = $user->firebase_token;
            $title              = "Test purchased";
            $message            = "You have successfully test course (".($order->questionSet->set_name ?? 'N/A').").";
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'                 => $sound,
                'icon'                  => 'notification_icon',
                'content_available'     => 1,
                'priority'              => 'high',
                'android_channel_id'    => 'android_channel_id',
            ];

            $customData = [
                'TYPE'      => "SYSTEM", 
                'PAGE_NAME' => 'MyTestDetails', 
                'PARAMS'    => json_encode([
                    'id'        => $order->id,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $meta = [
                'title' => $title,
                'message' => $message,
                'sound' => $sound,
                'platformConfig' => $platformConfig,
                'customData' => $customData,
            ];

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->type = "TEST";
            $notification->action_id = $order->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->meta = json_encode($meta);
            $notification->save();

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Send & save result submit notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendWalletAmountUseNotification(Order $order) 
    {
        
        try {
        
            $user   = User::find($order->user_id);
            
            if(empty($user) || empty($user->firebase_token)) {
                return false;
            }

            $firebase_token     = $user->firebase_token;
            $title              = "Wallet amount used";
            $message            = "You have used your wallet amount RS. ".$order->wallet_used_amount;
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'                 => $sound,
                'icon'                  => 'notification_icon',
                'content_available'     => 1,
                'priority'              => 'high',
                'android_channel_id'    => 'android_channel_id',
            ];

            $customData = [
                'TYPE'      => "SYSTEM", 
                'PAGE_NAME' => 'MyWallet', 
                'PARAMS'    => json_encode([
                    'id'        => $order->id,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $meta = [
                'title' => $title,
                'message' => $message,
                'sound' => $sound,
                'platformConfig' => $platformConfig,
                'customData' => $customData,
            ];

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->type = "SYSTEM";
            $notification->action_id = $order->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->meta = json_encode($meta);
            $notification->save();

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Send & save result submit notification
     *
     * @param  \App\Http\Requests\Request $request
     * @return void
    */
    public static function sendReferRewardCreditNotification(User $referUser) 
    {
        
        try {
        
            $user   = User::find($referUser->referrer_id);
            
            if(empty($user) || empty($user->firebase_token)) {
                return false;
            }

            $firebase_token     = $user->firebase_token;
            $title              = "Refer reward credited";
            $message            = "You have rewarded for refering with RS. " . $referUser->referrer_amount;
            $sound              = 'default';
            $customData         = [];
            
            $platformConfig = [
                'sound'                 => $sound,
                'icon'                  => 'notification_icon',
                'content_available'     => 1,
                'priority'              => 'high',
                'android_channel_id'    => 'android_channel_id',
            ];

            $customData = [
                'TYPE'      => "SYSTEM", 
                'PAGE_NAME' => 'ReferHistory',
                'PARAMS'    => json_encode([
                    'id'        => $referUser->id,
                    'referer'   => 'PushNotification'
                ])
            ];
            
            // dd($firebase_token);

            $meta = [
                'title' => $title,
                'message' => $message,
                'sound' => $sound,
                'platformConfig' => $platformConfig,
                'customData' => $customData,
            ];

            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->type = "SYSTEM";
            $notification->action_id = $referUser->id;
            $notification->title = $title;
            $notification->message = $message;
            $notification->meta = json_encode($meta);
            $notification->save();

            $response = (new Firebase)->send($firebase_token, $message, $title, $customData, $platformConfig);
            
            if(isset($response['status']) && $response['status']){

                return response()->json(['status' => true, 'data' => null, 'message' => 'Notification sent successfully'], 200);
            }

            return response()->json(['status' => false, 'data' => null, 'message' => $response['message']], 200);

        } catch (Exception $e) {
            
            return response()->json(['status' => false, 'data' => null, 'message' => $e->getMessage()], 200);
        }
    }
    
}
