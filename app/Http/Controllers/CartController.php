<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\ProductImage;
use App\Models\Address;
use App\Models\Stock;

class CartController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $cart_items = CartItem::where('user_id', '=', \Auth::user()->id)->get();
        $addresses = Address::where('user_id', '=', \Auth::user()->id)->get();

        return view('cart.index', [
            'cart_items' => $cart_items,
            'addresses' => $addresses
        ]);
    }

    public function add($id, Request $request) {
        $product = Product::find($id);
        $size = (int) $request->get('stock-size');


        if ($product) {
            $cart_item_exists = CartItem::where('product_id', '=', $product->id)->get();


            if (count($cart_item_exists) > 0) {
                foreach ($cart_item_exists as $cart_item_exist) {
                    if ($cart_item_exist->size == $size) {
                        $cart_item_exist->quantity += 1;

                        $cart_item_exist->update();
                    } else {
                        $cart_item = new CartItem();
                        $cart_item->user_id = \Auth::user()->id;
                        $cart_item->product_id = $product->id;
                        $cart_item->quantity = 1;
                        $cart_item->size = $size;
                        $cart_item->save();
                    }
                }
            } else {
                $cart_item = new CartItem();
                $cart_item->user_id = \Auth::user()->id;
                $cart_item->product_id = $product->id;
                $cart_item->quantity = 1;
                $cart_item->size = $size;
                $cart_item->save();
            }
        }

        return redirect()->route('home')->with(['message', $product->brand . " " . $product->name . " " . 'added to cart']);
    }

    public function moreQuantity($id) {
        $cart_item = CartItem::find($id);

        if ($cart_item) {
            $stocks = Stock::where('product_id', '=', $cart_item->product_id)
                            ->where('size', '=', $cart_item->size)->get();
            foreach ($stocks as $stock) {
                if ($stock->quantity > $cart_item->quantity) {
                    $cart_item->quantity++;
                    $cart_item->update();
                }
            }
        }

        return redirect()->route('cart.index');
    }

    public function lessQuantity($id) {
        $cart_item = CartItem::find($id);

        if ($cart_item) {
            $cart_item->quantity--;
            $cart_item->update();
        }

        return redirect()->route('cart.index');
    }

    public function delete($id) {
        $cart_item = CartItem::find($id);

        if ($cart_item) {
            $cart_item->delete();
        }

        return redirect()->route('cart.index')->with(['message' => 'Item deleted from cart']);
    }

}
