<?php

namespace App\CentralLogics;

use App\Models\BusinessSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;

class Helpers
{
    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

    public static function get_business_settings($name){
        $config = null;

        $payment_method = BusinessSetting::where('key', $name)->first();
        if($payment_method){
            $config = json_decode(json_encode($payment_method->value), true);
            $config = json_decode($config, true);
        }

        return $config;
    }

    public static function currency_code(){
        return BusinessSetting::where(['key' => 'currency'])->first()->value;
    }

    public static function send_order_notification($order, $token){
        try{
            $status = $order->order_status;
            $value = self::order_status_update_message($status);

            if($value){
                $data = [
                    'title' => trans('messages.order_push_title'),
                    'description' => $value,
                    'order_id' => $order->id,
                    'image' => '',
                    'type' => 'order_status',
                ];

                ////ERROR IS HERE
                self::send_push_notif_to_device($token, $data);

                try{
                    // save the notification to db
                    DB::table('user_notifications')->insert([
                        'data' =>json_encode($data),
                        'user_id' => $order->user_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                
                }
                catch(\Exception $e){
                   return response()->json([$e], 403);
                }
            }

            return true;

        }
        catch(\Exception $e){
            info($e);
        }

        return false;
    }

    public static function send_push_notif_to_device($fcm_token, $data, $delivery=0){
        /**
         * "key" is the FCM server key. Can be obtained from firebase projects.
         * Steps in obtaining server key:
         * 1. head to https://firebase.google.com/
         * 2. click "Go to console"
         * 3. select/ create a project
         * 4. click on project settings.
         * 5. click cloud messaging
         * 6. enable "Cloud Messaging API (Legacy)" by clicking the three dots in the right side 
         * 7. Then copy server key
         * 
         * 
         * 
         * "fcm_token" is the device token obtained from the phone
         * steps in obtaining :
         * Read : https://firebase.google.com/docs/cloud-messaging/flutter/client
         */
        $key=0;
        if($delivery==1){
            $key = BusinessSetting::where(['key' => 'delivery_boy_push_notification_key'])->first()->value; 
        }
        else{
            $key = BusinessSetting::where(['key' => 'push_notification_key'])->first()->value;
        }

        /// NB : CHECK:
        /// 1. title_loc_key
        /// 2. body_loc_key

        // "data":{} is what one sees when notification arrives.
        // "noitification": {} is what information that is contained in that notification
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = array(
            // 'authorization: key='.$key->content."",
            'authorization: key='.$key."",
            'content-type: application/json'
        );
        $postdata = '{
            "to":"'.$fcm_token.'",
            "mutable_content":true,
            "data":{
                "title":"'.$data['title'].'",
                "body":"'.$data['description'].'",
                "order_id":"'.$data['order_id'].'",
                "type":"'.$data['type'].'",
                "is_read":0
            },
            "notification":{
                "title":"'.$data['title'].'",
                "body":"'.$data['description'].'",
                "order_id":"'.$data['order_id'].'",
                "title_loc_key":"'.$data['order_id'].'", 
                "body_loc_key":"'.$data['type'].'", 
                "type":"'.$data['type'].'",
                "is_read":0,
                "icon":"new",
                "android_channel_id":"iEats"
            }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // get url content
        $result = curl_exec($ch);
        if($result == FALSE){
            dd(curl_error($ch));
        }

        curl_close($ch);
        
        return $result;
    }

    public static function order_status_update_message($status){

        if($status == 'pending'){
            $data = BusinessSetting::where(['key' => 'order_pending_message'])->first();
        }
        else if($status == 'confirmed'){
            $data = BusinessSetting::where('key', 'order_confirmation_msg')->first();
        }
        else if($status == 'processing'){
            $data = BusinessSetting::where('key', 'order_processing_message')->first();
        }
        else if($status == 'picked_up'){
            $data = BusinessSetting::where('key', 'out_for_delivery_message')->first();
        }
        else if($status == 'handover'){
            $data = BusinessSetting::where('key', 'order_handover_message')->first();
        }
        else if($status == 'delivered'){
            $data = BusinessSetting::where('key', 'order_delivered_message')->first();
        }
        else if($status == 'delivery_boy_delivered'){
            $data = BusinessSetting::where('key', 'delivery_boy_delivered_message')->first();
        }
        else if($status == 'delivery_boy_start'){
            $data = BusinessSetting::where('key', 'delivery_boy_start_message')->first();
        }
        else if($status == 'accepted'){
            $data = BusinessSetting::where('key', 'delivery_boy_assign_message')->first();
        }
        else if($status == 'canceled'){
            $data = BusinessSetting::where('key', 'order_canceled_message')->first();
        }
        else if($status == 'refunded'){
            $data = BusinessSetting::where('key', 'order_refunded_message')->first();
        }
        else{
            $data = '{"status":"0", "message":""}';
        }

        // return $data['value']['message']; // This is not working


        /**
         * $data->value = "{"status":"1","message":"Your order is successful"}"
         */
        $my_data = $data->value;
        $data_object = json_decode($my_data);
        /**
         * $data_object->message = "Your order is successful"
         */
        return $data_object->message;
        
    }
}