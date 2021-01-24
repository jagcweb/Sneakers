<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Region;
use App\Models\Order;

class AddressController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $addresses = Address::where('user_id', '=', \Auth::user()->id)->get();


        return view('address.all', [
            'addresses' => $addresses
        ]);
    }

    public function create() {

        $regions = Region::orderBy('region_name', 'ASC')->get();

        return view('address.create', [
            'regions' => $regions
        ]);
    }

    public function save(Request $request) {
        $addresses = Address::where('default_address', '=', 1)
                        ->where('user_id', '=', \Auth::user()->id)->get();

        $name = $request->input('name');
        $surname1 = $request->input('surname1');
        $surname2 = $request->input('surname2');
        $address_input = $request->input('address');
        $region = $request->get('region');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');



        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'surname1' => ['required', 'string', 'max:50'],
            'surname2' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'region' => ['string'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'numeric']
        ]);

        $address = new Address();

        if ($address) {
            $address->user_id = \Auth::user()->id;
            $address->name = $name;
            $address->surname1 = $surname1;
            $address->surname2 = $surname2;
            $address->address = $address_input;
            $address->region = $region;
            $address->city = $city;
            $address->postal_code = $postal_code;

            if ($addresses != null) {
                $exists_default_address = count($addresses);

                if ($exists_default_address < 1) {
                    $address->default_address = 1;
                } else {
                    $address->default_address = 0;
                }
            } else {
                $address->default_address = 1;
            }



            $address->save();
        }
        
        if(\Cookie::get('order') != null){
            return redirect()->route('order.address')->with(['message' => 'Saved address']);
        }else{
            return redirect()->route('address.index')->with(['message' => 'Saved address']);
        }
        
    }

    public function setDefault($id) {
        $old_default_address = Address::where('default_address', '=', 1)
                        ->where('user_id', '=', \Auth::user()->id)->first();

        var_dump($old_default_address);


        $new_default_address = Address::find($id);

        if ($old_default_address && $new_default_address) {
            $new_default_address->default_address = 1;
            $new_default_address->update();

            $old_default_address->default_address = 0;
            $old_default_address->update();
        } elseif ($old_default_address == null) {
            $new_default_address->default_address = 1;
            $new_default_address->update();
        }

        return redirect()->route('address.index')->with(['message' => 'The default address has been changed']);
    }

    public function edit($id) {
        $regions = Region::all();

        $address = Address::find($id);

        return view('address.edit', [
            'regions' => $regions,
            'address' => $address
        ]);
    }

    public function update($id, Request $request) {

        $name = $request->input('name');
        $surname1 = $request->input('surname1');
        $surname2 = $request->input('surname2');
        $address_input = $request->input('address');
        $region = $request->get('region');
        $city = $request->input('city');
        $postal_code = $request->input('postal_code');

        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'surname1' => ['required', 'string', 'max:50'],
            'surname2' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'numeric']
        ]);

        $address = Address::find($id);

        if ($address) {
            $address->user_id = \Auth::user()->id;
            $address->name = $name;
            $address->surname1 = $surname1;
            $address->surname2 = $surname2;
            $address->address = $address_input;
            $address->region = $region;
            $address->city = $city;
            $address->postal_code = $postal_code;

            $address->update();
        }
        return redirect()->route('address.index')->with(['message' => 'Updated address']);
    }

    public function delete($id) {
        $address = Address::find($id);
        $orders = Order::where('address_id', '=', $address->id)->get();

        if ($address) {
            if ($address->default_address == 1) {
                $new_default_address = Address::where('user_id', '=', \Auth::user()->id)->where('id', '!=', $id)->orderBy('id', 'asc')->first();

                if ($new_default_address != null) {
                    \DB::table('addresses')
                            ->where('id', $new_default_address->id)
                            ->update(['default_address' => 1]);
                }
            }

            foreach ($orders as $order) {
                $order->order_items()->delete();
            }
            $address->orders()->delete();

            $address->delete();
        }
        return redirect()->route('address.index')->with(['message' => 'Deleted address']);
    }

}
