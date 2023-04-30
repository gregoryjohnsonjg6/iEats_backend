<?php
namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller{
    
    // get all address list
     public function address_list(Request $request)
    {
        return response()->json(CustomerAddress::where('user_id', $request->user()->id)->latest()->get(), 200);
    }

    public function getCurrency(){
        $currency = Helpers::currency_code();
        // $currency = Helpers::order_status_update_message("confirmed");
        return response()->json(["currency" => $currency], 200);
    }

    // http://127.0.0.1:8000/api/v1/send-fcm
    public function sendFCM(){
        $fcm_device_token = "fAAa6zf6Qmun1gPpS_SB5S:APA91bGpRb9Tj5IH8euL35Zako6TAwA6YO6V_FF7WoHYFuWqhsX3RGX_nDPoXnPXuikr-5K9xkh-J5s9sEhP3zonPgAQoBlKWCFFLKyNrgw89BT_Fe1hXlWlJiIgHb_TxirVyiHyyqkf";
        $data = [
            'title' => "This is my title",
            'description' => "This is my description",
            'order_id' => 11,
            'image' => '',
            'type' => 'order_status',
        ];
        $response = Helpers::send_push_notif_to_device( $fcm_device_token, $data);
        return response()->json(["Fcm response" => json_decode($response)], 200);

    }

    public function info(Request $request)
    {
        $data = $request->user();
        
        //$data['order_count'] =0;//(integer)$request->user()->orders->count();
        //$data['member_since_days'] =(integer)$request->user()->created_at->diffInDays();
        //unset($data['orders']);
        return response()->json($data, 200);
    }
        public function add_new_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
          
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Error with the address"], 403);
        }


        $address = [
            'user_id' => $request->user()->id,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('customer_addresses')->insert($address);
        return response()->json(['message' => trans('messages.successfully_added')], 200);
    }
        public function update_address(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'contact_person_number' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        /*$point = new Point($request->latitude,$request->latitude);
        $zone = Zone::contains('coordinates', $point)->first();
        if(!$zone)
        {
            $errors = [];
            array_push($errors, ['code' => 'coordinates', 'message' => trans('messages.out_of_coverage')]);
            return response()->json([
                'errors' => $errors
            ], 403);
        }*/
        $address = [
            'user_id' => $request->user()->id,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_number' => $request->contact_person_number,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'zone_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('customer_addresses')->where('user_id', $request->user()->id)->update($address);
        return response()->json(['message' => trans('messages.updated_successfully'),'zone_id'=>$zone->id], 200);
    }

    public function update_cm_firebase_token(Request $request){
        $validator = Validator::make($request->all(), [
            'cm_firebase_token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => Helpers::error_processor($validator)
            ]);
        }

        DB::table('users')->where('id', $request->user()->id)->update([
            'cm_firebase_token' => $request['cm_firebase_token']
        ]);

        return response()->json([
            'message' => trans('message.updated_successfully')
        ]);
    }
}