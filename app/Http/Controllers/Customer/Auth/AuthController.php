<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    public function login()
    {
        return view('customer.auth.sign-in');
    }

    public function signIn(LoginRequest $request)
    {
        $remember = 1;

        if (!Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')], $remember)) {
            session()->flash('messages', 'Email adresi veya şifre hatalı.');
            session()->flash('alert-color', 'red');

            //return redirect()->back();
            return response()->json([
                'message' => 'Giriş Bilgileriniz Doğru!',
                'data' => [
                    'email' => $request->get('email'),
                    'password' => $request->get('password')
                ]
            ], 200);
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::logout();

        //return route('auth.signin');
        return response()->json([
            'status' => true,  
            'message' => 'Çıkış Yaptınız!',
        ], 200);
    }
}
