<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Address;
use App\Models\OrderItem;
use App\Models\Region;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Mail;
use App\Mail\AfterOrder;

class OrderController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin')->except('create', 'save', 'detail', 'changeAddress', 'userAll', 'sendMail');
    }

    public function create(Request $request) {


        if ($request->has('id') && $request->get('id') != null) {
            $address = Address::where('id', '=', $request->get('id'))->get();
        } else {
            $address = Address::where('default_address', '=', 1)
                            ->where('user_id', '=', \Auth::user()->id)->get();
        }


        return view('order.create', [
            'address' => $address
        ]);
    }

    public function changeAddress() {
        $addresses = Address::orderBy('id', 'desc')->where('user_id', '=', \Auth::user()->id)->get();

        return view('order.address', [
            'addresses' => $addresses
        ]);
    }

    public function save(Request $request) {

        $cart_items = CartItem::where('user_id', '=', \Auth::user()->id)->get();



        $address_id = \Session::get('address_id');
        $observations = \Session::get('observations');

        var_dump($address_id);
        echo "<br/>";
        var_dump($observations);

        $order = new Order();

        if ($order) {

            $order->user_id = \Auth::user()->id;
            $order->address_id = $address_id;
            $order->status = 'pagado';
            $order->observations = $observations;
            $order->total_price = \CountCartItem::calcTotalPrice()['total_price'];
            $order->date_order = date('Y-m-d');
            $order->reference = time();

            $order->save();

            foreach ($cart_items as $cart_item) {
                $order_items = new OrderItem();
                $order_items->order_id = $order->id;
                $order_items->product_id = $cart_item->product_id;
                $order_items->quantity = $cart_item->quantity;
                if ($cart_item->product->discount > 0) {
                    $calc_discount = $cart_item->product->price * $cart_item->product->discount / 100;
                    $price = $cart_item->product->price - $calc_discount;
                    $price_with_discount = number_format($price, 2);

                    $order_items->price = $price_with_discount;
                    $order_items->discount = $cart_item->product->discount;
                } else {
                    $order_items->price = $cart_item->product->price;
                    $order_items->discount = 0;
                }
                $order_items->size = $cart_item->size;

                $stocks = Stock::where('product_id', '=', $cart_item->product_id)
                                ->where('size', '=', $cart_item->size)->get();

                foreach ($stocks as $stock) {
                    $stock->quantity -= $cart_item->quantity;

                    $stock->update();
                }

                $order_items->save();
            }


            $cart_items = CartItem::where("user_id", '=', \Auth::user()->id);
            $cart_items->delete();
        }
        return redirect()->route('sendmail');
    }

    public function sendMail(Order $order) {
        $order = $order->newQuery();

        $order->whereHas('user', function($query) {
            $query->where('email', '=', \Auth::user()->email);
        });

        $order = $order->orderBy('id', 'desc')->first();

        $user = User::where('email', '=', \Auth::user()->email)->first();
        Mail::to($user->email)->send(new AfterOrder($order));


        return redirect()->route('home')->with(['message' => 'Thank you for shopping at Sneakers!']);
    }

    public function index() {
        return view('order.index');
    }

    public function all(Request $request) {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $reference = $request->input('reference');
        if (!empty($date1) && !empty($date2) && !empty($reference)) {
            $orders = Order::where('reference', '=', $reference)
                            ->whereBetween('date_order', [$date1, $date2])->paginate(5);
        } elseif (!empty($date1) && !empty($date2) && empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])->paginate(5);
        } elseif (!empty($reference) && empty($date1) && empty($date2)) {
            $orders = Order::where('reference', '=', $reference)->paginate(5);
        } else {
            $orders = Order::orderBy('date_order', 'desc')->paginate(5);
        }

        return view('order.all', [
            'orders' => $orders
        ]);
    }

    public function pending(Request $request) {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $reference = $request->input('reference');
        if (!empty($date1) && !empty($date2) && !empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '!=', 'finalizado')
                            ->where('reference', '=', $reference)->paginate(5);
        } elseif (!empty($date1) && !empty($date2) && empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '!=', 'finalizado')->paginate(5);
        } elseif (!empty($reference) && empty($date1) && empty($date2)) {
            $orders = Order::where('status', '!=', 'finalizado')
                            ->where('reference', '=', $reference)->paginate(5);
        } else {
            $orders = Order::where('status', '!=', 'finalizado')->paginate(5);
        }
        return view('order.pending', [
            'orders' => $orders
        ]);
    }

    public function finalized(Request $request) {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $reference = $request->input('reference');
        if (!empty($date1) && !empty($date2) && !empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '=', 'finalizado')
                            ->where('reference', '=', $reference)->paginate(5);
        } elseif (!empty($date1) && !empty($date2) && empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '=', 'finalizado')->paginate(5);
        } elseif (!empty($reference) && empty($date1) && empty($date2)) {
            $orders = Order::where('status', '=', 'finalizado')
                            ->where('reference', '=', $reference)->paginate(5);
        } else {
            $orders = Order::where('status', '=', 'finalizado')->paginate(5);
        }


        return view('order.finalized', [
            'orders' => $orders
        ]);
    }

    public function canceled(Request $request) {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        $reference = $request->input('reference');
        if (!empty($date1) && !empty($date2) && !empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '=', 'cancelado')
                            ->where('reference', '=', $reference)->paginate(5);
        } elseif (!empty($date1) && !empty($date2) && empty($reference)) {
            $orders = Order::whereBetween('date_order', [$date1, $date2])
                            ->where('status', '=', 'cancelado')->paginate(5);
        } elseif (!empty($reference) && empty($date1) && empty($date2)) {
            $orders = Order::where('status', '=', 'cancelado')
                            ->where('reference', '=', $reference)->paginate(5);
        } else {
            $orders = Order::where('status', '=', 'cancelado')->paginate(5);
        }


        return view('order.canceled', [
            'orders' => $orders
        ]);
    }

    public function detail($id) {
        $orders = Order::where('id', '=', $id)->get();

        return view('order.detail', [
            'orders' => $orders
        ]);
    }

    public function edit($id) {
        $order = Order::find($id);
        $regions = Region::orderBy('region_name', 'ASC')->get();

        return view('order.edit', [
            'order' => $order,
            'regions' => $regions
        ]);
    }

    public function update($id, $address_id, Request $request) {
        $order = Order::find($id);

        if ($order->status == 'pagado') {
            $name = $request->input('name');
            $surname1 = $request->input('surname1');
            $surname2 = $request->input('surname2');
            $address_input = $request->input('address');
            $region = $request->get('region');
            $city = $request->input('city');
            $postal_code = $request->input('postal_code');
            $status = $request->input('status');

            $validate = $this->validate($request, [
                'name' => ['required', 'string', 'max:50'],
                'surname1' => ['required', 'string', 'max:50'],
                'surname2' => ['required', 'string', 'max:50'],
                'address' => ['required', 'string', 'max:255'],
                'region' => ['string'],
                'city' => ['required', 'string', 'max:100'],
                'postal_code' => ['required', 'numeric'],
                'status' => ['required', 'string', 'max:50']
            ]);

            $address = Address::find($address_id);

            $address->name = $name;
            $address->surname1 = $surname1;
            $address->surname2 = $surname2;
            $address->address = $address_input;
            if ($address->region != $region) {
                $address->region = $region;
            }
            $address->city = $city;
            $address->postal_code = $postal_code;

            $address->update();


            $order->status = $status;

            $order->update();
        }

        if ($order->status != 'pagado' && $order->status != 'finalizado' && $order->status != 'cancelado') {
            $status = $request->input('status');

            $validate = $this->validate($request, [
                'status' => ['required', 'string', 'max:50']
            ]);

            $order->status = $status;

            $order->update();
        }

        if ($order->status == 'finalizado' || $order->status == 'cancelado') {
            return redirect()->route('order.manage.finalized');
        }

        return redirect()->route('order.manage.pending');
    }

    public function userAll(Request $request) {
        $date1 = $request->input('date1');
        $date2 = $request->input('date2');
        if (!empty($date1) && !empty($date2)) {
            $orders = Order::where('user_id', '=', \Auth::user()->id)
                            ->whereBetween('date_order', [$date1, $date2])->paginate(5);
        } else {
            $orders = Order::where('user_id', '=', \Auth::user()->id)
                            ->orderBy('id', 'desc')->paginate(5);
        }

        return view('order.user-all', [
            'orders' => $orders
        ]);
    }

}
