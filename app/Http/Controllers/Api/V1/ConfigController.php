<?php

namespace App\Http\Controllers\Api\V1;
use App\Models\Zone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use App\CentralLogics\Helpers;
use Grimzy\LaravelMysqlSpatial\Types\Point;


class ConfigController extends Controller
{
        public function geocode_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
       
        /// Get the address name based on the latitude and longitude received.
        /// Google map api key is obtained from : https://console.cloud.google.com/google/maps-apis/credentials?project=ieats-381804
        /**
         * API KEY for all devices AIzaSyDIcs-cXjaLkxO4FHUXdAJsUSXG4UjuvWE
         * API KEY for only iOS devices AIzaSyDnyW47ZnMaCi0sNgUfAbe4lWIZmTh7O1A
         * API KEY for only android devices AIzaSyB9txBevFfFt2ENt4pvW8-Ch6PWfyxHsNo
         */
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$request->lat.','.$request->lng.'&key='."AIzaSyDIcs-cXjaLkxO4FHUXdAJsUSXG4UjuvWE");
        return $response->json();
    }
        public function get_zone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->errors()->count()>0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $point = new Point($request->lat,$request->lng);
        //$zones = Zone::contains('coordinates', $point)->latest()->get();
       /* if(count($zones)<1)
        {
            return response()->json(['message'=>trans('messages.service_not_available_in_this_area_now')], 404);
        }
        foreach($zones as $zone)
        {
            if($zone->status)
            {
                return response()->json(['zone_id'=>$zone->id], 200);
            }
        }*/
        //return response()->json(['message'=>trans('messages.we_are_temporarily_unavailable_in_this_area')], 403);
         return response()->json(['zone_id'=>1], 200);
    }

    public function place_api_autocomplete(Request $request){
        $validator = Validator::make($request->all(), [
            "search_text" => "required",
        ]);

        // If there is any errors
        if($validator->errors()->count()>0){
            return response()->json(
                ["errors" => Helpers::error_processor($validator)],
                403
            );
        }

        /// DBESTECH API KEY: AIzaSyCMESvjp3G5FtPnukZ28_GVOuFSvEhSS9c
        /// My Api Key, though not authorize : AIzaSyDIcs-cXjaLkxO4FHUXdAJsUSXG4UjuvWE

        $response = Http::get(
            "https://maps.googleapis.com/maps/api/place/autocomplete/json?input="
            .$request["search_text"]
            ."&key="
            ."AIzaSyCMESvjp3G5FtPnukZ28_GVOuFSvEhSS9c"
        );

        return $response->json();

    }

    public function place_api_details(Request $request){
        /// DBESTECH API KEY: AIzaSyCMESvjp3G5FtPnukZ28_GVOuFSvEhSS9c
        /// My Api Key, though not authorize : AIzaSyDIcs-cXjaLkxO4FHUXdAJsUSXG4UjuvWE


        $validator = Validator::make($request->all(), [
            "placeid" => "required",
        ]);

        // If there is any errors
        if($validator->errors()->count()>0){
            return response()->json(
                ["errors" => Helpers::error_processor($validator)],
                403
            );
        }

        $response = Http::get(
            "https://maps.googleapis.com/maps/api/place/details/json?placeid="
            .$request["placeid"]
            ."&key="
            ."AIzaSyCMESvjp3G5FtPnukZ28_GVOuFSvEhSS9c"
        );

        return $response->json();
    }
}
