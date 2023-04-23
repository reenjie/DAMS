<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $validate = User::where('email', $email)->get();



        if (count($validate) >= 1) {
            $founduser = $validate[0]->password;
            if (Hash::check($password, $founduser)) {
                if (Auth::attempt($credentials)) {
                    return redirect()->route('home');
                }
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }
        } else {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }




        //r#MB5jcC
    }

    public function register(Request $request)
    {
        return view('auth.register');
    }
    public function registerUser(Request $request)
    {
        $proxy = $request->proxy;
        $proxyName = $request->proxyname;

        $name = $request->name;
        $contactno = $request->contactno;
        $email = $request->email;
        $address = $request->address;
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string'],
            'contactno' => ['required', 'max:11'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'proxy' => $proxy,
            'proxyName' => $proxyName,
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'contactno' => $contactno,
            'clinic' => 0,
            'user_type' => 'patient',
            'password' => Hash::make($password),
            'fl' => 1,
            'otp' => 0,
        ]);


        if ($user) {
            $credentials = [
                'email' => $email,
                'password' => $password
            ];

            if (Auth::attempt($credentials)) {
                return redirect()->route('home');
            }
        }
    }

    public function passwordrequest(Request $request)
    {
        return view('auth.passwords.email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}
