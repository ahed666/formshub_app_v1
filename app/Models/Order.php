<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Order extends Model
{
    use HasFactory;
    protected $table="orders";
    public static function allOrders()
    {
         $orders=self::all();
         $allOrders = [];
         $today = Carbon::now()->startOfDay();
         foreach ($orders as $key => $order) {




            $items=OrderProduct::join('type_of_devices','order_products.product_id','=','type_of_devices.id')->join('devices_models','devices_models.id','=','type_of_devices.model_id')->where('order_products.order_id','=',$order->id)
            ->select('type_of_devices.*','devices_models.device_model','order_products.quantity')->get()->toArray();
            $orderData = [
                'id'=>$order->id,
                'name' => $order->name,
                'email' => $order->email,
                'location' => $order->location,
                'mobile_number' => $order->mobile_number,
                'status'=>$order->status,
                'items' => $items, /* ... */ // Provide the array of ordered items
                'total' => $order->total,/* ... */// Calculate the order total
                'today'=>$order->created_at->startOfDay()->eq($today),
                'created_at'=>$order->created_at,
            ];




            // Pushing the arrayData into resultArray
            array_push($allOrders,$orderData);

         }
       return $allOrders;
    }

}
