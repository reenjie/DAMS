<?php

use Illuminate\Support\Facades\Route;
use App\Models\Clinic;
use App\Models\Category;
use App\Models\Email;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();

Route::post('logged', [App\Http\Controllers\AuthController::class, 'index'])->name('login');
Route::post('loggedout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('register', [App\Http\Controllers\AuthController::class, 'registerUser'])->name('registerUser');
Route::get('resetpassword', [App\Http\Controllers\AuthController::class, 'passwordrequest'])->name('password.request');
Route::get('/', function () {
    $title = 'Patient Appointment Scheduling MS';
    $def = Email::all();
    foreach ($def as $email) {
        $default = $email->email;
        $token = $email->token;
        $medname = $email->name;

        session(['email' => $default]);
        session(['token' => $token]);
        session(['e_name' => $medname]);
    }


    if (session()->has('onetimepin')) {
    } else {
        session(['onetimepin' => substr(number_format(time() * rand(), 0, '', ''), 0, 6)]);
    }


    $clinics = Clinic::all();
    return view('welcome', compact('clinics', 'title'));
});

Route::get('/Book', function () {
    $clinic = DB::select('select * from clinics where id in (select clinic from doctors) ');

    $clinics = Clinic::all();
    $category = Category::all();
    return view('book', compact('clinic', 'clinics'));
});


Route::get('/agreement', function () {
    return view('Agreement');
})->name('agreement');

Route::post('updateagreement', [App\Http\Controllers\AgreementController::class, 'update'])->name('updateagreement');


Route::controller(App\Http\Controllers\BookController::class)->group(function () {
    Route::prefix('Home')->name('home.')->group(function () {
        Route::get('getcategory', 'category')->name('category');
        Route::get('getdoctor', 'doctor')->name('doctor');
        Route::post('Book', 'book')->name('submit');

        Route::get('disapprove/booking', 'disapprove_booking')->name('disapprove_booking');
        Route::get('approve/booking', 'approve_booking')->name('approve_booking');

        Route::get('complete/booking', 'complete_booking')->name('complete_booking');

        Route::get('Cxhasd', 'checkifexist')->name('checkifexist');

        Route::get('viewbook', 'viewbook')->name('viewbook');

        Route::get('conduct', 'conduct')->name('conduct');
    });
});




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Validations
Route::get('checkpoint', [App\Http\Controllers\HomeController::class, 'checkpoint'])->name('checkpoint');

Route::post('/home', [App\Http\Controllers\HomeController::class, 'verify'])->name('verifyotp');

Route::get('/Schedules', function () {
    $title = 'Patient Appointment Scheduling MS';
    $sched = Schedule::where('isOne',null)->get();
    $datenow = date('Y-m-d');
    $doctorwsched = DB::select('select * from users where user_type = "doctor" and id in (select doctorid from schedules where "' . $datenow . '" < dateofappt  ) ');


    return view('schedules', compact('sched', 'doctorwsched', 'title'));
});

Route::get('/Doctors', function () {
    $title = 'Patient Appointment Scheduling MS';
    $doctor = User::where('user_type', 'doctor')->get();
    $clinics = Clinic::all();
    return view('doctors', compact('doctor', 'clinics', 'title'));
});

Route::get('/AboutUs', function () {

    return view('aboutus');
});






Route::controller(App\Http\Controllers\AdminController::class)->group(function () {
    Route::prefix('Account')->name('admin.')->group(function () {

        Route::get('Dashboard', 'dashboard')->name('dashboard');
        Route::get('Appointments', 'appointment')->name('appointment');
        Route::get('Patients', 'patient')->name('patient');
        Route::get('Specialization', 'category')->name('category');
        Route::get('Doctors', 'doctors')->name('doctors');
        Route::get('Referral_Station', 'referral')->name('referral');
        Route::get('Feedbacks', 'feedback')->name('feedback');
        Route::get('Add/Doctors', 'adddoctor')->name('adddoctor');
        Route::get('{id}/Updating/Doctors-Data/Doctors', 'edit_doctor')->name('edit_doctor');

        Route::get('Approved/Booking', 'approved')->name('approved');
        Route::get('Approved/Booking/Successful', 'completed')->name('completed');
        Route::get('Cancelled/Booking/Successful', 'cancelled')->name('cancelled');
        Route::get('Disapproved/Booking', 'disapproved')->name('disapproved');
        Route::get('Referrals/Refer/Patient', 'refer')->name('refer');
        Route::get('Accepting/Referral', 'accept_referral')->name('accept_referral');


        Route::post('attachedfile', 'attachedfile')->name('attachedfile');
        Route::get('removeAttachment', 'removeAttachment')->name('removeAttachment');

        Route::get('Schedules', 'schedules')->name('schedules');

        Route::get('downloadWithData', 'downloadWithData')->name('downloadWithData');
        Route::get('downloadalldata', 'downloadalldata')->name('downloadalldata');

        Route::post('createmultipleappt','createmultipleappt')->name('createmultipleappt');
    });
});


Route::controller(App\Http\Controllers\UserController::class)->group(function () {
    Route::prefix('MyAccount')->name('user.')->group(function () {

        Route::get('Dashboard', 'dashboard')->name('dashboard');
        Route::get('Booking/Appointment', 'book')->name('book');
        Route::get('Viewing/Pending/Booking', 'view_pending')->name('view_pending');
        Route::get('Cancel/Booking', 'cancel')->name('cancel');
        Route::get('Viewing/Cancelled/Booking', 'view_cancel')->name('cancelled');
        Route::get('Viewing/Approved/Booking', 'view_approved')->name('view_approved');
        Route::get('Viewing/Completed/Booking', 'view_completed')->name('view_completed');

        Route::get('Viewing/Disapproved/Booking', 'view_disapproved')->name('view_disapproved');

        Route::post('Book', 'booknow')->name('submit');

        Route::get('Send/Feedbacks', 'feedback')->name('feedback');
    });
});


Route::controller(App\Http\Controllers\SuperadminController::class)->group(function () {
    Route::prefix('Admin')->name('superadmin.')->group(function () {

        Route::get('Dashboard', 'dashboard')->name('dashboard');
        Route::get('Clinics', 'clinics')->name('clinics');
        Route::get('Specialization', 'specialization')->name('specialization');
        Route::get('Doctors', 'doctors')->name('doctors');
        Route::get('Admin', 'admin')->name('admin');
        Route::get('Patients', 'patients')->name('patients');
        Route::get('Add/Clinics', 'add_clinic')->name('add_clinic');
        Route::get('{id}/Update/Clinics', 'edit_clinic')->name('edit_clinic');
        Route::get('sort_by/clinics/categories/{id}', 'sort_clinics')->name('sort_clinics');
        Route::get('{id}/Updating/Doctors-Data/Doctors', 'edit_doctor')->name('edit_doctor');
        Route::get('Adding/Doctors', 'add_doctor')->name('add_doctor');
        Route::get('getcategory', 'getcategory')->name('getcategory');
        Route::get('Adding/Admin', 'add_admin')->name('add_admin');
        Route::get('{id}/Updating/Admin/Administrator', 'edit_admin')->name('edit_admin');

        Route::get('Adding/Patient', 'add_patient')->name('add_patient');

        Route::get('{id}/Updating/Patients/MD-patients', 'edit_patient')->name('edit_patient');
    });
});

/* Add Functions */
Route::controller(App\Http\Controllers\Actions\Add_Controller::class)->group(function () {


    Route::prefix('Adding')->name('add.')->group(function () {
        Route::post('Add_category', 'add_category')->name('add_category');
        Route::post('Add_clinic', 'add_clinic')->name('add_clinic');
        Route::post('add_doctor', 'add_doctor')->name('add_doctor');
        Route::post('add_admin', 'add_admin')->name('add_admin');
        Route::post('add_patient', 'add_patient')->name('add_patient');
        Route::post('sendfeedback', 'sendfeedback')->name('sendfeedback');

        Route::post('saveschedule', 'saveschedule')->name('saveschedule');
    });
});


/* Edit Functions */
Route::controller(App\Http\Controllers\Actions\Edit_Controller::class)->group(function () {


    Route::prefix('Editing')->name('edit.')->group(function () {
        Route::post('Edit_category', 'edit_category')->name('edit_category');
        Route::post('Edit_clinic', 'edit_clinic')->name('edit_clinic');
        Route::post('edit_doctor', 'edit_doctor')->name('edit_doctor');
        Route::post('edit_admin', 'edit_admin')->name('edit_admin');
        Route::post('edit_patient', 'edit_patient')->name('edit_patient');

        Route::get('update_referral', 'update_referral')->name('update_referral');

        Route::post('rebook', 'rebook')->name('rebook');
        Route::get('resend', 'resend')->name('resend');

        Route::get('cancel_appointment', 'cancel_appointment')->name('cancel_appointment');
        Route::get('update_doctor_stat', 'update_doctor_stat')->name('update_doctor_stat');

        Route::get('Account', 'account')->name('account');
        Route::post('updateaccount', 'updateaccount')->name('updateaccount');
        Route::get('firslogin', 'firslogin')->name('firslogin');

        Route::get('accept_newSchedule', 'accept_newSchedule')->name('accept_newSchedule');
        Route::post('saveoutbook', 'saveoutbook')->name('saveoutbook');
        Route::post('userrebook', 'userrebook')->name('userrebook');
    });
});

/* Delete Functions */
Route::controller(App\Http\Controllers\Actions\Delete_Controller::class)->group(function () {


    Route::prefix('Deleting')->name('delete.')->group(function () {
        Route::get('delete_Category', 'delete_Category')->name('delete_Category');
        Route::get('delete_clinic', 'delete_clinic')->name('delete_clinic');
        Route::get('delete_doctor', 'delete_doctor')->name('delete_doctor');
        Route::get('delete_admin', 'delete_admin')->name('delete_admin');
        Route::get('delete_feedback', 'delete_feedback')->name('delete_feedback');
        Route::get('delete_appt', 'delete_appt')->name('delete_appt');

        Route::get('deletesched', 'deletesched')->name('deletesched');
    });
});

Route::controller(App\Http\Controllers\Actions\Delete_Controller::class)->group(function () {


    Route::prefix('Deleting')->name('delete.')->group(function () {
        Route::get('delete_Category', 'delete_Category')->name('delete_Category');
        Route::get('delete_clinic', 'delete_clinic')->name('delete_clinic');
        Route::get('delete_doctor', 'delete_doctor')->name('delete_doctor');
        Route::get('delete_admin', 'delete_admin')->name('delete_admin');
        Route::get('delete_feedback', 'delete_feedback')->name('delete_feedback');
        Route::get('delete_appt', 'delete_appt')->name('delete_appt');
    });
});


Route::controller(App\Http\Controllers\MailController::class)->group(function () {

    Route::prefix('sendingMail')->name('mail.')->group(function () {

        Route::get('sendcredentials', 'sendcredentials')->name('sendCredentials');
        Route::get('sendCredentials_patient', 'sendCredentials_patient')->name('sendCredentials_patient');

        Route::get('notify_patient', 'notify_patient')->name('notify_patient');
        Route::post('resetlink', 'resetlink')->name('resetlink');
        Route::post('resetpassword', 'resetpassword')->name('resetpassword');

        Route::get('sendOTP', 'sendOTP')->name('sendOTP');

        Route::get('NotifyAdminIfReferredsuccess', 'NotifyAdmin_ifReferedSuccessful')->name('NotifyAdminIfReferredsuccess');

        Route::get('NotifyAdmin_ReceivedFeedback', 'NotifyAdmin_ReceivedFeedback')->name('NotifyAdmin_ReceivedFeedback');

        Route::get('notifylaps', 'notifylaps')->name('notifylaps');

        Route::get('notify_userrebook', 'notify_userrebook')->name('notify_userrebook');

        Route::get('sendConduct', 'sendConduct')->name('sendConduct');

        Route::get('notfu','notifyusers')->name('notifyusers');
       
    });
});


/**Email SEtting */
Route::post('/get-token', [App\Http\Controllers\OauthController::class, 'doGenerateToken'])->name('generate.token');
Route::get('/get-token', [App\Http\Controllers\OauthController::class, 'doSuccessToken'])->name('token.success');
Route::post('/send', [App\Http\Controllers\MailController::class, 'doSendEmail'])->name('send.email');

Route::get('ResetPassword', function (Request $request) {
    $id = $request->token;
    return view('auth.passwords.reset', compact('id'));
});

Route::get('test', function () {

    return view('testmail');
});



Route::namespace('App\Http\Controllers')->group(function () {
    Route::get('/google/login', 'GauthController@redirectToGoogle')->name('google.login');
    Route::get('/google/callback', 'GauthController@handleGoogleCallback')->name('google.callback');
});
