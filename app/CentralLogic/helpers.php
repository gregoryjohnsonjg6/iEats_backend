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
}