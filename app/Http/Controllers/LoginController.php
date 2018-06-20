<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('./');
    }
    public function postLogin(Request $request) {
        $rules = [
            'email' =>'required|email',
            'password' => 'required|min:8'
        ];
        $messages = [
            'email.email' => 'Email không đúng định dạng',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->input('email');
            $password = $request->input('password');

            if( Auth::attempt(['email' => $email, 'password' =>$password])) {
                return redirect()->back()->withInput();
            } else {
                $errors = new MessageBag(['errorlogin' => 'Email hoặc mật khẩu không đúng']);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        }
    }
    public function addUser(Request $r) {
        $user = new User;
        $user->name = $r->username;
        $user->email = $r->email;
        $user->password = Hash::make($r->password);
        $user->save();
        if( Auth::attempt(['email' => $r->email, 'password' => $r->password])) {
                return redirect()->back()->withInput();
            } else {
                $errors = new MessageBag(['errorlogin' => 'Email hoặc mật khẩu không đúng']);
                return redirect()->back()->withInput()->withErrors($errors);
            }
        return view('homepage');
    }

    public function forgotPassword(Request $r) {
        return $r->email;
    }
}
