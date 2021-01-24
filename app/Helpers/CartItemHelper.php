<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;

class CountCartItem {

    public static function countItems() {
        if(\Auth::user() != null){
            $cart_items = CartItem::where('user_id', '=', \Auth::user()->id)->get();
        }else{
            $cart_items = CartItem::where('user_id', '==', 0)->get();
        }

        return $cart_items;
    }
    
    public static function countTotalQuantityOfStock($id, $size) {
        $stocks = Stock::where('product_id', '=', $id)
                        ->where('size', '=', $size)->get();
        $cantidad_de_producto=0;
        foreach ($stocks as $stock){
            $cantidad_de_producto = $stock->quantity;
        }

        return $cantidad_de_producto;
    }

    public static function calcTotalPrice() {
        $cart_items = CartItem::where('user_id', '=', \Auth::user()->id)->get();
        $subtotal_price = 0;
        $total_price = 0;
        $shipping_tax = 0;



        foreach ($cart_items as $cart_item) {
          if($cart_item->product->discount>0){
                $calc_discount = $cart_item->product->price * $cart_item->product->discount / 100;
                $price = $cart_item->product->price - $calc_discount;
                $price_with_discount = number_format($price,2);
                $price_product = $price_with_discount * $cart_item->quantity;
            $subtotal_price += $price_product;
          }else{
                $price_product = $cart_item->product->price * $cart_item->quantity;
            $subtotal_price += $price_product;
          }
        }

        if ($subtotal_price < 100) {
            $shipping_tax += 4.99;
            $total_price = $subtotal_price;
            $total_price += $shipping_tax; 
        }else{
            $total_price = $subtotal_price;
        }

        $price_array = array(
            'shipping_tax' => $shipping_tax,
            'total_price' => $total_price,
            'subtotal_price' => $subtotal_price
        );

        return $price_array;
    }
    

    public static function calcPriceWithDiscount($id) {
        $products = Product::where('id', '=', $id)->get();

        $price = 0;
        $price_with_discount = 0;
        $calc_discount = 0;

        foreach ($products as $product) {
            if ($product->discount > 0) {
                $calc_discount = $product->price * $product->discount / 100;
                $price = $product->price - $calc_discount;
                $price_with_discount = number_format($price,2);
            }
        }
        return $price_with_discount;
    }

}
