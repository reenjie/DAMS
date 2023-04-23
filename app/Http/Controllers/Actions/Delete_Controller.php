<?php

namespace App\Http\Controllers\Actions;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\Schedule;


class Delete_Controller extends Controller
{
    //
    public function delete_Category(Request $request){
       Category::where('id',$request->id)->delete();
       return redirect()->back()->with('Success','Category was Deleted Successfully!');
    }

    public function delete_clinic(Request $request){
        Clinic::where('id',$request->id)->delete();
        return redirect()->back()->with('Success','Clinic and all its connected data  was Deleted Successfully!');
    }

    public function delete_doctor(Request $request){
        User::where('id',$request->id)->delete();

        return redirect()->back()->with('Success','Doctors data  was Deleted Successfully!');
    }

    public function delete_admin(Request $request){
        User::where('id',$request->id)->delete();

        return redirect()->back()->with('Success','Admin  was Deleted Successfully!');
    }

    public function delete_feedback(Request $request){
        Feedback::where('user_id',$request->id)->delete();
        return redirect()->back()->with('Success','Feedback  was Deleted Successfully!');
    }
    public function delete_appt(Request $request){
        Appointment::where('id',$request->id)->delete();
        return redirect()->back()->with('Success','Appointment was Deleted Successfully!');
    }

    public function deletesched(Request $request){
        Schedule::findorFail($request->id)->delete();
        return redirect()->back()->with('Success','Schedule Deleted Successfully!');
    }
}
