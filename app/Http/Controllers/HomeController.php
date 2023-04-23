<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      $usertype = Auth::user()->user_type;
      echo 'aww';
      if(Auth::user()->otp == 0){

        //Send OTP hold User.
          if($usertype == 'superadmin'){
            //If superadmin. Redirect to page

              return redirect()->route("superadmin.specialization");
          }else {
            //All other users. send OTP
            return redirect()->route('checkpoint');
          }
      }else {
    
        switch ($usertype) {
          case 'superadmin':
            return redirect()->route("superadmin.specialization");
        
            break;

            case 'doctor':
             
              return redirect()->route("admin.dashboard");
              break;

              case 'patient' :
                return redirect()->route('user.dashboard');
              break;
       
        }

      }

       
  
      
    }

    public function checkpoint(){
     $otp = session()->get('onetimepin');
      return redirect()->route('mail.sendOTP');
    }

    public function verify(Request $request){
      $otp = session()->get('onetimepin');
      $inputtedPin = $request->input('otp');

     
      if($otp == $inputtedPin){
        User::where('id',Auth::user()->id)->update([
          'otp'=>1,
        ]);

        $usertype = Auth::user()->user_type;
        switch ($usertype) {
            case 'admin':
              return redirect()->route("admin.dashboard");
              break;

              case 'doctor':
             
                return redirect()->route("admin.dashboard");
                break;

              case 'patient' :
                return redirect()->route('user.dashboard');
              break;
       
        }

      }else {
        return redirect()->back()->with('error','Code Undefined');
      }
     
    }

    


}
