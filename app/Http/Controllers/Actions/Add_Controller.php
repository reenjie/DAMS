<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Add_Controller extends Controller
{
    public function add_category(Request $request){
       Category::create([
        'name' => $request->input('category'),
       ]);
       return redirect()->back()->with('Success','Specialization was Added Successfully!');

    }

    public function add_clinic(Request $request){
        $request->validate([
            'name' => 'required|unique:clinics',
            'street' => 'required',
            'barangay' => 'required',
            'city' => 'required',
        ]);

        Clinic::create([
            'name' => $request->input('name'),
            'street' => $request -> input('street'),
            'barangay' => $request -> input('barangay'),
            'city' => $request -> input('city'),
        ]);

        return redirect()->route('superadmin.clinics')->with('Success','Clinic was Added Successfully!');
    }

    public function add_doctor(Request $request){
        
        $request->validate([
            'Firstname'=> 'required',
            'Lastname' => 'required',
            'Email' => 'required',
            'Contact' => 'required',
            'License' => 'required',
            'Street' =>'required',
            'Barangay' =>'required',
            'City' => 'required',
            'password'=>'required'
           
        ]);
        
         $specialization = serialize($request->specialization);

          

        User::create([
            'name' => $request->input('Firstname').' '.$request->input('Lastname'),
            'email' => $request->input('Email'),
            'address' => $request->input('Street').' '.$request->input('Barangay').' '.$request->input('City'),
            'contactno' => $request->input('Contact'),
            'license'=> $request->input('License'),
            'specialization'=>$request->specialization,
            'user_type' => 'doctor',
            'specialization'=>$specialization,
            'password' => Hash::make($request->input('password')),
            'fl'=>0,
            'otp'=>0,
            'designation'=>'doctor',
        ]);
        return redirect()->route('superadmin.doctors')->with('Success','New Doctor was Added Successfully!');
        if(Auth::user()->user_type == 'superadmin'){
            return redirect()->route('superadmin.doctors')->with('Success','New Doctor was Added Successfully!');
        }else {
            return redirect()->route('admin.doctors')->with('Success','New Doctor was Added Successfully!');
        }

     
    }

    public function add_admin(Request $request){
       
     
        $request->validate([
          //  'Designation'=>'required',
            'Email' => 'required|unique:users',
            'Contact'=>'required',
            'Name' =>'required',
            'Address'=>'required',
        ]);
   
        $default_password = Hash::make($request->password);
       User::create([
            'email'=>$request->input('Email'),
            'contactno'=>$request->input('Contact'),
            'name'=>$request->input('Name'),
            'user_type'=>'superadmin',
            'password'=>$default_password,
            'address'=>$request->input('Address'),
            'clinic'=>$request->input('Clinic'),
            'fl'=>0,
            'otp'=>0,
            'designation'=>'admin',
          //  'designation'=>$request->input('Designation'),
        ]);

        
        return redirect()->route('mail.sendCredentials',['email'=>$request->input('Email'),'name'=>$request->input('Name'),'password'=>'admin_1234']);



    }

    public function add_patient(Request $request){
        $request->validate([
            'Email' => 'required|unique:users',
            'Contact'=>'required',
            'Name' =>'required',
            'Address'=>'required',
          
        ]);


        $default_password = Hash::make($request->input('Email'));
        User::create([
             'email'=>$request->input('Email'),
             'contactno'=>$request->input('Contact'),
             'name'=>$request->input('Name'),
             'user_type'=>'patient',
             'password'=>$default_password,
             'address'=>$request->input('Address'),
             'clinic'=>0,
             'fl'=>0,
             'otp'=>0,
             'designation'=>null,
         ]);
 
         
         return redirect()->route('mail.sendCredentials_patient',['email'=>$request->input('Email'),'name'=>$request->input('Name')]);


        
 
 



    }

    public function sendfeedback(Request $request){
      $userid = Auth::user()->id;
      $clinic = $request->input('selected');
      $message = $request->input('message');
      $from = $request->input('from');

      if($from == 'from_user'){

        Feedback::create([
            'user_id'=>$userid,
            'message'=>$message,
            'clinic'=>$clinic,
            'from_user'=>1,
            'from_clinic'=>0,
          ]);
          
         $alluser = User::where('clinic',$clinic)->get();

         $username  = User::findorFail($userid)->name;

        foreach ($alluser as $key => $value) {
            $all[]=$value->email;
        }
        return redirect()->route('mail.NotifyAdmin_ReceivedFeedback',['message'=>$message,'alluser'=>$all,'Username'=>$username]);

      }else {
        $userid = $request->input('userid');
        $clinic = Auth::user()->clinic;

        Feedback::create([
            'user_id'=>$userid,
            'message'=>$message,
            'clinic'=>$clinic,
            'from_user'=>0,
            'from_clinic'=>1,
          ]);

          return redirect()->back(); 

      }
        
  
  
    }

    public function saveschedule(Request $request){
      $doa = $request->doa;
      $timestart = $request->timestart;
      $timeend   = $request->timeend;
      $remarks   = $request->remarks;
      $noofpatient = $request->noofpatient;
      $id = Auth::user()->id;

      if(date('Y-m-d') > $doa){
        return redirect()->back()->with('Error','Date is Invalid. Please provide future dates.');
      }
    
        $check = DB::select('SELECT * FROM `schedules` WHERE doctorid ='.$id.' and dateofappt = "'.$doa.'" and "'.$timestart.'" between timestart and timeend and "'.$timeend.'" between timestart and timeend');

        if(count($check)>=1){
         
        return redirect()->back()->with('Error','Conflict Schedules.Please Check the Date of Appointment and its time.');
        }else {
         
        Schedule::create([
            'doctorid'  =>Auth::user()->id,
            'dateofappt'=>$doa,
            'timestart'=>$timestart,
            'timeend'=>$timeend,
            'remarks'=>$remarks,
            'status'=>0,
            'specializationID'=>Auth::user()->specialization,
            'noofpatients'=>$noofpatient,
        ]);

        return redirect()->back()->with('Success','Schedule Saved Successfully!');
        }

    }

}
