<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemHelper {

    public static function countOrderItems($id) {
        $quantity = 0;
        $order_items = OrderItem::where('order_id', '=', $id)->get();
        foreach ($order_items as $order_item) {
            $quantity += $order_item->quantity;
        }

        return $quantity;
    }

    public static function calcTotalPriceOrder($id) {
        $orders = Order::where('id', '=', $id)->get();
        $total_price = 0;
        $shipping_tax = 0;



        foreach ($orders as $order) {
            foreach ($order->order_items as $order_items) {
                $price_product = $order_items->price * $order_items->quantity;
                $total_price += $price_product;
            }
        }

        if ($total_price < 100) {
            $shipping_tax += 4.99;
            $total_price += $shipping_tax;
        }

        $price_array = array(
            'shipping_tax' => $shipping_tax,
            'total_price' => $total_price
        );

        return $price_array;
    }

}
