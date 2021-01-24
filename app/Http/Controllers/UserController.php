<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\AfterContact;

class UserController extends Controller {

    public function __construct() {
        $this->middleware('auth')->except('privacyPolicy', 'shippingAndReturns', 'contact', 'sendContactMail');
        $this->middleware('admin')->except('config', 'getImage', 'update', 'privacyPolicy', 'shippingAndReturns', 'contact', 'sendContactMail');
    }

    public function admin() {

        return view('user.admin');
    }

    public function config() {
        return view('user.config');
    }

    public function update(Request $request) {
        $user = \Auth::user();
        $id = $user->id;
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $id],
            'image' => ['image']
        ]);

        $name = $request->input('name');
        $surname = $request->input('surname');
        $email = $request->input('email');

        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;

        $avatar = $request->file('avatar');
        if ($request->has('avatar') && $avatar != null) {
            $avatar_name = time() . $avatar->getClientOriginalName();
            \Storage::disk('users')->put($avatar_name, \File::get($avatar));

            $user->image = $avatar_name;
        }
        $user->update();
        return redirect()->route('config')->with(['message' => 'User updated successfully!']);
    }

    public function getImage($filename) {
        $file = \Storage::disk('users')->get($filename);

        return new Response($file, 200);
    }

    public function privacyPolicy() {

        return view('user.privacy');
    }

    public function shippingAndReturns() {

        return view('user.shipping-nd-returns');
    }

    public function contact() {

        return view('user.contact');
    }

    public function sendContactMail(Request $request) {
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'reason' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string']
        ]);

        $data = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'reason' => $request->input('reason'),
            'description' => $request->get('description')
        );
        
        /*$data->name = $request->input('name');
        $data->email = $request->input('email');
        $data->reason = $request->input('reason');
        $data->description = $request->get('description');*/
        
         Mail::to('jagcweb.sneakers@gmail.com')->send(new AfterContact($data));
         
         return redirect()->route('contact')->with(['message' => 'Your contact request has been sent']);
    }

}
