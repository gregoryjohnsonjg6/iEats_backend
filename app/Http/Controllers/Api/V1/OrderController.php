<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CentralLogics\Helpers;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
        public function place_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_amount' => 'required',
            'address' => 'required_if:order_type,delivery',
            //'longitude' => 'required_if:order_type,delivery',
           // 'latitude' => 'required_if:order_type,delivery',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $address = [
            'contact_person_name' => $request->contact_person_name?$request->contact_person_name:$request->user()->f_name.' '.$request->user()->f_name,
            'contact_person_number' => $request->contact_person_number?$request->contact_person_number:$request->user()->phone,
            'address' => $request->address,
            'longitude' => (string)$request->longitude,
            'latitude' => (string)$request->latitude,
        ];

        $product_price = 0;

        $order = new Order();
        $order->id = 100000 + Order::all()->count() + 1; //checked
        $order->user_id = $request->user()->id; //checked 
        $order->order_amount = $request['order_amount']; //checked 
        $order->order_note = $request['order_note']; //checked
        $order->delivery_address = json_encode($address); //checked
        $order->otp = rand(1000, 9999); //checked
        $order->pending = now(); //checked
        $order->created_at = now(); //checked
        $order->updated_at = now();//checked
        
        foreach ($request['cart'] as $c) {
     
                $product = Food::find($c['id']); //checked
                if ($product) {
            
                    $price = $product['price']; //checked 
                    
                    $or_d = [
                        'food_id' => $c['id'], //checked
                        'food_details' => json_encode($product), 
                        'quantity' => $c['quantity'], //checked
                        'price' => $price, //checked
                        'created_at' => now(), //checked
                        'updated_at' => now(), //checked 
                        'tax_amount' => 10.0
                    ];
                    
                    $product_price += $price*$or_d['quantity'];
                    $order_details[] = $or_d;
                } else {
                    return response()->json([
                        'errors' => [
                            ['code' => 'food', 'message' => 'not found!']
                        ]
                    ], 401);
                }
        }


        try {
            $save_order= $order->id;
            $total_price= $product_price;
            $order->order_amount = $total_price;
            $order->save();
            
            foreach ($order_details as $key => $item) {
                $order_details[$key]['order_id'] = $order->id;
            }
            /*
            insert method takes array of arrays and insert each array in the database as a record.
            insert method is part of query builder
            */
            OrderDetail::insert($order_details);

            return response()->json([
                'message' => trans('messages.order_placed_successfully'),
                'order_id' =>  $save_order,
                'total_ammount' => $total_price,
                
            ], 200);
        } catch (\Exception $e) {
            return response()->json([$e], 403);
        }

        return response()->json([
            'errors' => [
                ['code' => 'order_time', 'message' => trans('messages.failed_to_place_order')]
            ]
        ], 403);
    }

    public function get_order_list(Request $request)
    {
        $orders = Order::withCount('details')->where(['user_id' => $request->user()->id])->get()->map(function ($data) {
            $data['delivery_address'] = $data['delivery_address']?json_decode($data['delivery_address']):$data['delivery_address'];   

            return $data;
        });
        return response()->json($orders, 200);
    }
    
}
