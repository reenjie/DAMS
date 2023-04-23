<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Ref_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
class Edit_Controller extends Controller
{
    //
    public function edit_category(Request $request){
        $id = $request->input('id');
        $name = $request->input('category');
            Category::where('id',$id)->update([
                'name'=>$name,
            ]);

        return redirect()->back()->with('Success','Specialization was Updated Successfully!');
    }

    public function edit_clinic(Request $request){
        $id = $request->input('id');

        Clinic::where('id',$id)->update([
            'name' => $request->input('name'),
            'street' => $request -> input('street'),
            'barangay' => $request -> input('barangay'),
            'city' => $request -> input('city'),
        ]);
        return redirect()->route('superadmin.clinics')->with('Success','Clinic was Updated Successfully!');

    }

    public function edit_doctor(Request $request){
       
        $id = $request->input('id');

        $request->validate([
            'name'=> 'required',
            'Email' => 'required',
            'Contact' => 'required',
            'address' =>'required',
           
        ]);

        User::findorFail($id)->update([
            'name' => $request->name,
            'email' => $request->Email,
            'address' => $request->address,
            'contactno' => $request->Contact,
            'specialization'=> $request->specialization,
           
        ]);
        
       return redirect()->route('superadmin.doctors')->with('Success','New Doctor was Added Successfully!');
     
        // if(Auth::user()->user_type == 'superadmin'){
        //     return redirect()->route('superadmin.doctors')->with('Success','New Doctor was Added Successfully!');
        // }else {
        //     return redirect()->route('admin.doctors')->with('Success','New Doctor was Added Successfully!');
        // }
      
    }

    public function edit_admin(Request $request){
     
        $request->validate([
            'Contact'=>'required',
            'Name' =>'required',
            'Address'=>'required',
        ]);
       

        User::where('id',$request->input('id'))->update([
            
            'contactno'=>$request->input('Contact'),
            'name'=>$request->input('Name'),
            'address'=>$request->input('Address'),
        ]);

        return redirect()->route('superadmin.admin')->with('Success','Admin Data was Updated Successfully!');
    }


    
    public function edit_patient(Request $request){
        $request->validate([
            'Contact'=>'required',
            'Name' =>'required',
            'Address'=>'required',
        ]);


        User::where('id',$request->input('id'))->update([
            
            'contactno'=>$request->input('Contact'),
            'name'=>$request->input('Name'),
            'address'=>$request->input('Address'),
           
        ]);

        return redirect()->route('superadmin.patients')->with('Success','Patient Data was Updated Successfully!');
    }

    public function update_referral(Request $request){
       $id= $request->id;
       $remarks= $request->remarks;
       $doctor = $request->DoctorId;
       $clinic = $request->clinic;
    

   
   Appointment::where('id',$id)->update([
            'remarks'=> $remarks,
            'refferedto_doctor'=>$doctor,
            'status' => 5,
        ]);



        $appt = Appointment::where('id',$request->id)->get();
        $userid = $appt[0]['user_id'];
        $schedID= $appt[0]['apptID'];

      
        $schedule =Schedule::findorFail($schedID);

        $adate = $schedule->dateofappt;
        $timestart = $schedule->timestart;
        $timeend = $schedule->timeend;

      
        
        $udetails = User::where('id',$userid)->get();
        $email = $udetails[0]['email'];
        $name = $udetails[0]['name'];

        
      
        
      Ref_history::create([
            "user_id" =>$userid ,
            "fromdoctor" => $appt[0]['doctor']  ,
            "todoctor" =>  $doctor ,
            "remarks"=>$remarks,
        ]);


        $doc = DB::select('select * from users where id = '.Auth::user()->id.' ');
        $doctorname = $doc[0]->name;
   
        $ReceivingUser = User::where('id',$doctor)->get();

        $notify_receiver=$ReceivingUser[0]['email'];
        $notify_name=$ReceivingUser[0]['name'];
  

    return redirect()->route('mail.notify_patient',
    ['email'=>$email,
    'name'=>$name,
    'doa'=>$adate,
    'timstart'=>$timestart,
    'timeend' => $timeend,
    'tp' =>'refered',
    'remarks'=>$request->remarks,
    'treatment'=>$request->treatment,
    'doctorname'=>$doctorname,
    'receiver'=>$notify_receiver,
    'receivername'=>$notify_name]);
        
  
    }

    public function rebook(Request $request){
        $shedID = $request->scheduleid;
        $id     = $request->id;
        $doctor = $request->doctor;
        $patient= $request->patient;
        $categoryid = $request->categoryid;
       

        //echo $shedID.$id.$doctor.$patient.$categoryid;

        $schedule = Schedule::findorFail($shedID);
        $doa = $schedule->dateofappt;
        $timestart = $schedule->timestart;
        $timeend   = $schedule->timeend;

       
        $appt = Appointment::findorFail($id);
       
        $appt->update([
            'apptID'=>$shedID, 
            'ad_status' =>0,
            'doctor'=>$doctor,
            'status'=>1,
            'category'=>$categoryid,
        ]);
 

        $userid = $appt->user_id;
           
      
        $udetails = User::where('id',$userid)->get();
        $email = $udetails[0]['email'];
        $name = $udetails[0]['name'];

       
          
      return redirect()->route('mail.notify_patient',['email'=>$email,'name'=>$name,'doa'=>$doa,'timestart'=>$timestart,'timeend'=>$timeend,'tp' =>'rebook']);
        // }else {
        //     Appointment::where('id',$id)->update([
        //         'dateofappointment'=>null,
        //         'timeofappointment'=>null,
        //          'ad_status'=>1,
        //         ]);

        //         $appt = Appointment::where('id',$id)->get();
        //         $userid = $appt[0]['user_id'];
            
        //         $adate = $appt[0]['dateofappointment'];
        //         $atime = $appt[0]['timeofappointment'];
        //         $udetails = User::where('id',$userid)->get();
        //         $email = $udetails[0]['email'];
        //         $name = $udetails[0]['name'];
        //         $clinicdetails = Clinic::where('id',$clinic)->get();
        //         $clinicname = $clinicdetails[0]['name'];
        //         $cliniclocation =  $clinicdetails[0]['street'].' ,'.$clinicdetails[0]['barangay'].' '.$clinicdetails[0]['city'];
        
        //         return redirect()->route('mail.notify_userrebook',['email'=>$email,'name'=>$name,'doa'=>$dop,'toa'=>$top,'cname'=>$clinicname,'loc'=>$cliniclocation,'tp' =>'rebook','remarks'=>$request->remarks,'treatment'=>$request->treatment]);

        // }

    
    }

    public function accept_newSchedule(Request $request){
        $id = $request->id;
        $doctorid = $request->doctor;
        $clinicid = $request->clinic;
        $specialization = Doctor::findorFail($doctorid)->category;

         Appointment::where('id',$id)->update([
            'clinic'=>$clinicid,
            'category'=>$specialization,
            'doctor'=>$doctorid,
            'status'=>1,
            'ad_status'=>0,
            'refferedto'=>0,
            'refferedto_doctor'=>0,
            'remarks'=>'',
        ]);

        return redirect()->route("user.dashboard")->with('accept','Appointment Accepted Successfully');
        
       
    }

    public function userrebook(Request $request){
       $schedid = $request->schedid;
        $id = $request->id;
      Appointment::where('id',$id)->update([
        'apptID'=>$schedid,
        'refferedto_doctor'=>0,
        'ad_status'=>0,
        'remarks'=>'',
    ]);

    return redirect()->route("user.dashboard")->with('saveaccept','Appointment Accepted Successfully');

    }

    public function resend(Request $request){
        $id = $request->id;
        $dop = $request->dop;
        $top= $request->top;
        Appointment::where('id',$id)->update([
            'dateofappointment'=>$dop,
            'timeofappointment'=>$top,
            'status'=>0,
            'remarks' => '',
        ]);

        return redirect()->back()->with('Success','Appointment was resent Successfully!');
    }

    public function cancel_appointment(Request $request){
        Appointment::where('id',$request->id)->update([
            'status'=>5,
            'remarks'=>$request->remarks,
        ]);
        return redirect()->back()->with('Success','Appointment was resent Successfully!');

    }

    public function update_doctor_stat(Request $request){
        Doctor::where('id',$request->id)->update([
            'isavailable'=>$request->stat,
        ]);
    }

    public function account(){
       return view('account');
    }

    public function updateaccount(Request $request){
        if($request->contactno){
            $Contact = $request->contactno;
        }else{
            $Contact = "";
        }
       
     if($request->input('password') == Auth::user()->password){
     
            if($request->file('userimage')){
                $imagefile = time().'.'.$request->file('userimage')->getClientOriginalExtension();
                $request->file('userimage')->move(public_path('profile'),$imagefile);
  

   User::where('id',Auth::user()->id)->update([
            'name'=>$request->input('name'),
            'address'=>$request->input('address')? $request->input('address') :"",
            'contactno'=>$Contact,
            'image'=>$imagefile
        ]);
            }else{
         User::where('id',Auth::user()->id)->update([
            'name'=>$request->input('name'),
            'address'=>$request->input('address')? $request->input('address'):"",
            'contactno'=>$Contact,
        ]);
            }

            
     }else {

        if($request->file('userimage')){
            $imagefile = time().'.'.$request->file('userimage')->getClientOriginalExtension();
            $request->file('userimage')->move(public_path('profile'),$imagefile);


User::where('id',Auth::user()->id)->update([
        'name'=>$request->input('name'),
        'address'=>$request->input('address')? $request->input('address'):"",
        'contactno'=>$Contact,
        'image'=>$imagefile,
        'password'=>Hash::make($request->input('password')),
    ]);
        }else{
     User::where('id',Auth::user()->id)->update([
            'name'=>$request->input('name'),
            'address'=>$request->input('address')? $request->input('address'):"",
            'contactno'=>$Contact,
            'password'=>Hash::make($request->input('password')),
        ]);
        }

      
     }

     $usertype = Auth::user()->user_type;
     switch ($usertype) {
       case 'superadmin':
     
        return redirect()->route("superadmin.dashboard")->with('upt','Account Updated Successfully');
         break;

         case 'admin':
   
       return redirect()->route("admin.dashboard")->with('upt','Account Updated Successfully');
           break;

           case 'patient' :
  
       return redirect()->route("user.dashboard")->with('upt','Account Updated Successfully');
           break;
    
            }

    }

    public function firslogin(Request $request){
        $id = Auth::user()->id;

        User::where('id',$id)->update([
            'fl'=>1,
            'password'=>Hash::make($request->newpass),
        ]);
       
    }

    public function saveoutbook(Request $request){
        $id     = $request->id;
        $doctor = $request->doctor;
        $patient= $request->patient;
        $categoryid = $request->categoryid;
       
       
        $appt = Appointment::findorFail($id);
        $appt->update([
            'apptID'=>0,
            'ad_status' =>3,
            'doctor'=>$doctor,
            'status'=>1,
            'category'=>$categoryid,
        ]);

        
        $userid = $appt->user_id;
           
      
        $udetails = User::where('id',$userid)->get();
        $email = $udetails[0]['email'];
        $name = $udetails[0]['name'];

        return redirect()->route('mail.notify_userrebook',
        ['email'=>$email,
        'name'=>$name,
       ]);


    }

}
