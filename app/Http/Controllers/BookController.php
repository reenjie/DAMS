<?php

namespace App\Http\Controllers;
use App\Models\Clinic;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Records;

use Illuminate\Http\Request;

class BookController extends Controller
{
   public function category(Request $request)
   {
      $id =  $request->sortby;
      $category = DB::select('select * from categories where id in (select category from doctors where clinic = ' . $id . ' ) ');

      echo '<select name="Category" class=" form-select" id="categories" >';
      echo '<option>Choose Specialization</option>';
      foreach ($category as $item) {
         echo '<option value="' . $item->id . '">' . $item->name . '</option>';
      }
      echo '</select>';

      echo '<script>$("#categories").change(function(){var val = $(this).val(); $.ajax({url : "' . route("home.doctor") . '",method :"get",
            data : {sortby:val},success : function(data){$("#doctor").html(data);} }) })</script>';
   }

   public function doctor(Request $request)
   {
      $id =  $request->sortby;
      $doctor = Doctor::where('category', $id)->get();

      echo '<select name="Doctor" class=" form-select" id="" >';
      echo '<option value="">Choose Doctor</option>';
      foreach ($doctor as $item) {
         echo '<option value="' . $item->id . '">' . $item->firstname . ' ' . $item->lastname . '</option>';
      }
      echo '</select>';
   }

   public function book(Request $request)
   {
      $schedid = $request->schedid;
      $specialization = $request->specialization;
      $doctorid = $request->doctorid;

      if (auth()->check()) {
         if (Auth::user()->user_type == 'patient') {
            $tab = 'dashboard';
            $check = Appointment::where('user_id', Auth::user()->id)->where('apptID', $schedid)->get();

            if (count($check) >= 1) {


               return redirect()->route('user.dashboard', compact('tab'))->with('Error', 'Booking unsuccessful!');
            } else {

               $save = Appointment::create([
                  'user_id' => Auth::user()->id,
                  'apptID' => $schedid,
                  'category' => $specialization,
                  'doctor' =>  $doctorid,
                  'dateofappointment' => null,
                  'timeofappointment' => null,
                  'refferedto' => 0,
                  'refferedto_doctor' => 0,
                  'remarks' => '',
                  'purpose' => $request->purpose,
                  'diagnostics' => '',
                  'treatment' => '',
                  'attachedfile' => null,
                  'status' => 0,
                  'ad_status' => 0,
                  'laps' => 0
               ]);

               if ($save) {


                  return redirect()->route('user.dashboard', compact('tab'))->with('Successbooked', 'Booked Successfully!');
               }
            }
         } else {
            return redirect('/');
         }
      } else {
         $schedid = $request->schedid;
         $specialization = $request->specialization;
         $doctorid = $request->doctorid;
         $datas = [
            'schedid' => $schedid,
            'specialization' => $specialization,
            'doctorid' => $doctorid,
            'purpose' => $request->purpose
         ];

         session(['saveappt' => $datas]);
         return redirect('/');
      }
   }

   public function disapprove_booking(Request $request)
   {

      $appt = Appointment::where('id', $request->id)->get();
      $userid = $appt[0]['user_id'];
      $apptID = $appt[0]['apptID'];

      $schedule = Schedule::findorFail($apptID);

      $adate = $schedule->dateofappt;
      $timestart = $schedule->timestart;
      $timeend = $schedule->timeend;
      $udetails = User::where('id', $userid)->get();
      $email = $udetails[0]['email'];
      $name = $udetails[0]['name'];


      Appointment::where('id', $request->id)->update([
         'status' => 3,
         'remarks' => $request->remarks,
      ]);


      return redirect()->route('mail.notify_patient', ['email' => $email, 'name' => $name, 'doa' => $adate, 'timestart' => $timestart, 'timeend' => $timeend, 'tp' => 'disapproved', 'remarks' => $request->remarks]);
   }

   public function approve_booking(Request $request)
   {

      $appt = Appointment::where('id', $request->id)->get();
      $userid = $appt[0]['user_id'];
      $apptID = $appt[0]['apptID'];

      $schedule = Schedule::findorFail($apptID);

      $adate = $schedule->dateofappt;
      $timestart = $schedule->timestart;
      $timeend = $schedule->timeend;
      $udetails = User::where('id', $userid)->get();
      $email = $udetails[0]['email'];
      $name = $udetails[0]['name'];


      Appointment::where('id', $request->id)->update([
         'status' => 1,
      ]);

      return redirect()->route('mail.notify_patient', ['email' => $email, 'name' => $name, 'doa' => $adate, 'timestart' => $timestart, 'timeend' => $timeend, 'tp' => 'approved', 'remarks' => $request->remarks]);
   }

   public function complete_booking(Request $request)
   {


      $appt = Appointment::where('id', $request->id)->get();
      $userid = $appt[0]['user_id'];
      $apptID = $appt[0]['apptID'];

      $schedule = Schedule::findorFail($apptID);

      $adate = $schedule->dateofappt;
      $timestart = $schedule->timestart;
      $timeend = $schedule->timeend;
      $udetails = User::where('id', $userid)->get();
      $email = $udetails[0]['email'];
      $name = $udetails[0]['name'];


      Appointment::where('id', $request->id)->update([
         'status' => 4,

      ]);

      Records::create([
         'appointment' => $request->id,
         'userID' => $userid,
         'remarks' => $request->remarks,
         'diagnostics' => $request->diagnostics,
         'treatment' => $request->treatment,
      ]);

      return redirect()->route('mail.notify_patient', ['email' => $email, 'name' => $name, 'doa' => $adate, 'timestart' => $timestart, 'timeend' => $timeend, 'tp' => 'completed', 'treatment' => $request->treatment, 'remarks' => $request->remarks]);

      /*    return redirect()->back()->with('Success','Appointment Completed Successfully. '); */
   }

   public function conduct(Request $request)
   {
      $id = $request->id;
      $appt = Appointment::findorFail($id);
      $userid = $appt->user_id;
      $user = User::findorFail($userid);
      $email = $user->email;
      $name  = $user->name;

      $appt->update([
         'status' => 1,
         'ad_status' => 3,
         'apptID' => 0
      ]);

      return redirect()->route('mail.sendConduct', ["email" => $email, "name" => $name]);
   }

   public function checkifexist(Request $request)
   {
      $apptdate =  $request->value;
      $appt = date('Y-m-d', strtotime($apptdate));
      $id = Auth::user()->id;
      $clinic = $request->id;

      $check = Appointment::where('user_id', $id)->where('dateofappointment', $appt)->where('clinic', $clinic)->where('status', 0)->get();


      if (count($check) >= 1) {
         echo 'Reserved';
      } else {
         echo 'Vacant';
      }
   }


   public function viewbook(Request $request)
   {

      $datenow = date('Y-m-d');
      function retrView($stats)
      {
         $id = Auth::user()->id;
         $data = Appointment::where('doctor', $id)->where('status', $stats)->get();
         return $data;
      }
      $alldoctor = User::where('user_type', 'doctor')->get();
      switch ($request->types) {
         case 'pending':
            $completeappt = Appointment::where('status', 0)->where('doctor', Auth::user()->id)->get();
            $data = retrView(0);

            break;
         case 'approved':
            $completeappt = Appointment::where('status', 1)->where('doctor', Auth::user()->id)->get();
            $data = retrView(1);

            break;

         case 'cancelled':
            $completeappt = Appointment::where('status', 2)->where('doctor', Auth::user()->id)->get();
            $data = retrView(2);

            break;

         case 'disapproved':
            $completeappt = Appointment::where('status', 3)->where('doctor', Auth::user()->id)->get();
            $data = retrView(3);

            break;

         case 'completed':
            $completeappt = Appointment::where('status', 4)->where('doctor', Auth::user()->id)->get();
            $data = retrView(4);

            break;
      }


      return view('admin.viewappt', compact('data', 'completeappt', 'alldoctor'));
   }
}
