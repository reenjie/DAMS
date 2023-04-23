<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\OAuth2\Client\Provider\Google;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{

    private $email;
    private $name;
    private $client_id;
    private $client_secret;
    private $token;
    private $provider;

    /**
     * Default Constructor
     */
    public function __construct()
    {


        $this->client_id        = env('GOOGLE_API_CLIENT_ID');
        $this->client_secret    = env('GOOGLE_API_CLIENT_SECRET');
        $this->provider         = new Google(
            [
                'clientId'      => $this->client_id,
                'clientSecret'  => $this->client_secret
            ]
        );
    }

    public function sendcredentials(Request $request)
    {
        $receiver = $request->email;
        $name = $request->name;
        $pass = $request->password;
        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($receiver, $name);
            $mail->Subject = 'Login Credentials';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Welcome new Administrator!
           
           
                   </h3>
                   <h4>Here are your Login Credentials,</h4>
           
           
           
           
                   <h4>Email: <span style="font-weight:bold">' . $receiver . '</span>
                       <br>
                       Password: <span style="font-weight:bold">' . $pass . '</span>
           
                   </h4>
           
                   <br>
                   <h5>
                       Do not share this to anyone.
                       <br>
           
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return redirect()->route('superadmin.admin')->with('Success', 'New Admin was Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }





    public function sendCredentials_patient(Request $request)
    {
        $receiver = $request->email;
        $name = $request->name;
        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($receiver, $name);
            $mail->Subject = 'Login Credentials';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color:white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Welcome ' . $name . '!
           
           
                   </h3>
                   <h4>You are registered to our Websites and Here are your Login Credentials,</h4>
           
           
           
           
                   <h4>Email: <span style="font-weight:bold">' . $receiver . '</span>
                       <br>
                       Password: <span style="font-weight:bold">' . $receiver . '</span>
           
                   </h4>
           
                   <br>
                   <h5>
                       Do not share this to anyone.
                       <br>
           
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return redirect()->route('superadmin.patients')->with('Success', 'New Patient was Added Successfully!');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }


    public function NotifyAdmin_ifReferedSuccessful(Request $request)
    {

        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($request->receiver, $request->name);
            $mail->Subject = 'NEW REFERRAL ALERT';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h3><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h3>
           
               <h3 style="color:rgb(14, 87, 136)">Hi Dr. ' . $request->name . ' <br>you have has received a Referral.
           
            
                   </h3>
                  
                  
                   <h4>

                 
                   <div style="padding:10px;">
                   <span >Patient Information</span>
                   <br>
                   <span >
                   Name : ' . $request->patientname . '
                   <br>
                   Email : ' . $request->patientemail . '
                   
                   </span>
                   </div>
                   </h6>
                 

                   <br>
                   <span >
                   Login To view more about the referral details.
                   </span>
                 


                   <br>
                   <h4>
                  
                   
                       <br>
                   
                       All rights Reserved &middot; 2023
           
                   </h3>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return redirect()->route('admin.referral')->with('Success', 'Patient  was referred Successfully!');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }



    public function notify_patient(Request $request)
    {

        $receiver = $request->email;
        $name = $request->name;
        $this->token = session()->get('token');



        $mail = new PHPMailer(true);


        if ($request->tp == 'approved') {
            $subj = 'BOOKING APPROVED!';
            $typo = '<span style="color:green">APPROVED</span>';
            $stat = 'approved!';
            $guided = 'Please Be at the Hospital at the Dates and Time Stated Above.
            ';
            $prop = '';
        } else if ($request->tp == 'disapproved') {
            $subj = 'BOOKING DISAPPROVED!';
            $typo = '<span style="color:red">DISAPPROVED</span>';
            $stat = 'disapproved!';
            $guided = 'Remarks: <br>' . $request->remarks;
            $prop = '';
        } else if ($request->tp == 'completed') {
            $subj = 'BOOKING COMPLETED';
            $typo = '<span style="color:blue">ACCOMPLISHED</span>';
            $stat = 'Completed! Thank you for using our webapp. <br>';
            $guided = 'Remarks: <br>' . $request->remarks . '<br> Treatment : <br>' . $request->treatment;
            $prop = '';
        } else if ($request->tp == 'refered') {
            $subj = 'APPOINTMENT BOOKING REFERRED';
            $prop = '';
            $typo = '<span style="color:red">REFERRED</span>';
            $stat = 'referred! For more info. Please Login to your account to check the Details of your referrals. <br>';
            $guided = 'Referred By: Dr. ' . $request->doctorname . ' <br/> Referred TO : Dr. ' . $request->receivername;
        } else if ($request->tp == 'rebook') {

            $subj = 'APPOINTMENT BOOKING REBOOK';
            $typo = '<span style="color:green">APPROVED AND REBOOK SUCCESSFULLY</span>';
            $prop = 'new';
            $stat = 'rebook and set!';
            $guided = 'Please Be at the Hospital at the Dates and Time Stated Above. <br/> Dr.' . Auth::user()->name . ' is waiting for you..';
        }

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($receiver, $name);
            $mail->Subject = $subj;
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white; ">
           <p><br><br><br></p>
           <div style="padding:20px">
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">BOOKING ' . $typo . '
           
           
                   </h3>
                   <h4>Hi ' . $name . ' Your ' . $prop . ' Booking  <br><br> Dated at : ' . date('F j,Y', strtotime($request->doa)) . '<br>
                   
                   And Time Frame : ' . date('h:i a', strtotime($request->timestart)) . ' - ' . date('h:i a', strtotime($request->timeend)) . ' <br> <br>
                   Has Been ' . $stat . ' <br> ' . $guided . '
                   </h4>
           
           
           
           
                   
           
                   <br>
                   <h5>
                     
                       <br>
           
                       All rights Reserved &middot; 2023
           
                   </h5>
                   </div>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                if ($request->tp == 'approved') {
                    return redirect()->back()->with('Success', 'Patient Booking Approved Successfully!');
                } else if ($request->tp == 'disapproved') {
                    return redirect()->back()->with('Success', 'Patient Booking Disapproved Successfully!');
                } else if ($request->tp == 'completed') {
                    return redirect()->back()->with('Success', 'Patient Booking Marked Done Successfully!');
                } else if ($request->tp == 'refered') {

                    //    
                    return redirect()->route('mail.NotifyAdminIfReferredsuccess', ['receiver' => $request->receiver, 'name' => $request->receivername, 'doctorname' => $request->doctorname, 'patientname' => $name, 'patientemail' => $receiver]);
                } else if ($request->tp == 'rebook') {
                    return redirect()->route('admin.referral')->with('Success', 'Referral Accepted and Appointment was set Successfully!');
                }
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function resetlink(Request $request)
    {
        $receiver = $request->input('email');
        $name = 'Online Doctor Appointment Management System Client';
        $user = User::where('email', $receiver)->get();

        $url =  'http://' . request()->getHttpHost() . '/ResetPassword?token=' . $user[0]['id'] . '&code=' . $user[0]['password'];



        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($receiver, $name);
            $mail->Subject = 'RESET LINK';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi!
           
            
                   </h3>
                   <h4>It seems like you forgot your password. <a href="' . $url . '">Click Here</a> To reset your password .</h4>
           
                 
                   <br>
                   <h5>
                   If this wasnt you. Please Login and Change your password.
                   <br>
                      Please Do not share this to anyone.
                       <br>
           
                       All rights Reserved &middot; 2023
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return redirect()->back()->with('Success', 'We have Emailed your Reset Link Please Check your Email.');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function resetpassword(Request $request)
    {

        $request->validate([
            'password' => ['confirmed'],
        ]);

        $id = $request->input('id');
        $password = Hash::make($request->input('password'));

        User::where('id', $id)->update([
            'password' => $password,
        ]);


        $time = date('h:i a  F j,Y');

        $user = User::where('id', $id)->get();

        $receiver = $user[0]['email'];
        $name = $user[0]['name'];


        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($receiver, $name);
            $mail->Subject = 'RESET SUCCESSFULLY';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: aquamarine;text-align:center">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi ' . $name . '!
           
            
                   </h3>
                   <h4>Your Password has changed Successfully! <br> DateTime: ' . $time . '</h4>


                   <br>
                   <h5>
                  
                   
                       <br>
           
                       All rights Reserved &middot; 2023
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return redirect('/')->with('Success', 'We have Emailed your Reset Link Please Check your Email.');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function sendOTP(Request $request)
    {

        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress(Auth::user()->email, Auth::user()->name);
            $mail->Subject = 'ONE-TIME-PIN';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi ' . Auth::user()->name . '!
           
            
                   </h3>
                   <h4>This is Your OTP ( One Time Pin ) <br> <span style="font-size:40px;color:#4f4f54">' . session()->get('onetimepin') . '</span></h4>


                   <br>
                   <h5>
                  
                   
                       <br>
                    <span style="color:red">Please dont share this to anyone. | No one can access your account without this PIN.</span>
                    <br/>
                       All rights Reserved &middot; 2023
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                return view('otp');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }


        //
    }
    public function NotifyAdmin_ReceivedFeedback(Request $request)
    {
        $message = $request->message;
        $emails = $request->alluser;
        $name   = $request->Username;

        foreach ($emails as $key => $receiver) {


            $this->token = session()->get('token');
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->AuthType = 'XOAUTH2';
                $mail->setOAuth(
                    new OAuth(
                        [
                            'provider'          => $this->provider,
                            'clientId'          => $this->client_id,
                            'clientSecret'      => $this->client_secret,
                            'refreshToken'      => $this->token,
                            'userName'          => session()->get('email')
                        ]
                    )
                );

                $mail->setFrom(session()->get('email'), session()->get('e_name'));
                $mail->addAddress($receiver, 'Admin');
                $mail->Subject = 'RECEIVED PATIENT FEEDBACKS';
                $mail->CharSet = PHPMailer::CHARSET_UTF8;
                $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">
                    We Have Received a Patient Feedback!
            
                   </h3>
                   <h4>From Patient : <br>
                   <span style="font-weight:bold">' . $name . '</span>
                   </h4>
                  
                       

                   <br>
                 <span style="font-weight:bold;font-size:11px">Message</span>   :  ' . $message . '
                  
                  
                   <h5>
                  
                   
                       <br>
                    <span style="color:green">Login your account If you wish to response. </span>
                    <br/>
                       All rights Reserved &middot; 2023
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
                $mail->msgHTML($body);
                $mail->AltBody = 'This is a plain text message body';
                if ($mail->send()) {
                } else {
                    return redirect()->back()->with('error', 'Unable to send email.');
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
            }
        }
        return redirect()->back();
    }


    public function notifylaps(Request $request)
    {
        $appt_id = $request->appt_id;
        $userid  = $request->userid;
        $email   = $request->email;
        $name    = $request->name;

        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($email, $name);
            $mail->Subject = 'Laps Appointment';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi ' . $name . '!
           
            
                   </h3>
                   <h4>You have a lapse appointment and This appointment will no longer be valid and automatically deleted.  <br>please rebook a new appointment. Thank you</h4>


                   <br>
                   <h5>
                  
                   
                       <br>
                    <span style="color:red">Have a great day.</span>
                    <br/>
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {
                Appointment::where('id', $appt_id)->delete();
                return redirect()->route('admin.appointment');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function notify_userrebook(Request $request)
    {
        $email = $request->email;
        $name  = $request->name;


        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($email, $name);
            $mail->Subject = 'REBOOK APPOINTMENT SCHEDULE';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi ' . $name . '!
           
            
                   </h3>
                   <h4>Your appointment booking has been referred to Dr. ' . Auth::user()->name . ' . and you are requested to rebook your schedule. <br> please login to your account and set your wished schedule. thank you.</h4>


                   <br>
                   <h5>
                  
                   
                       <br>
                    <span style="color:red">Have a great day.</span>
                    <br/>
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {

                return redirect()->route('admin.referral');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function sendConduct(Request $request)
    {
        $email = $request->email;
        $name  = $request->name;
        $this->token = session()->get('token');
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->SMTPAuth = true;
            $mail->AuthType = 'XOAUTH2';
            $mail->setOAuth(
                new OAuth(
                    [
                        'provider'          => $this->provider,
                        'clientId'          => $this->client_id,
                        'clientSecret'      => $this->client_secret,
                        'refreshToken'      => $this->token,
                        'userName'          => session()->get('email')
                    ]
                )
            );

            $mail->setFrom(session()->get('email'), session()->get('e_name'));
            $mail->addAddress($email, $name);
            $mail->Subject = 'FOLLOW UP CHECKUP';
            $mail->CharSet = PHPMailer::CHARSET_UTF8;
            $body = '<!DOCTYPE html>
           <html lang="en">
           
           <head>
               <meta charset="UTF-8">
               <meta name="viewport" content="width=device-width, initial-scale=1.0">
               <meta http-equiv="X-UA-Compatible" content="ie=edge">
               <title></title>
           </head>
           
           <body style="background-color: white">
           <p><br><br><br></p>
               <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
           
               <h3 style="color:rgb(14, 87, 136)">Hi ' . $name . '!
           
            
                   </h3>
                   <h4> Dr. ' . Auth::user()->name . ' has set an you an appointment for follow up checkup ,  and you are requested to book your schedule. <br> please login to your account and set your wished schedule. thank you.</h4>


                   <br>
                   <h5>
                  
                   
                       <br>
                    <span style="color:red">Have a great day.</span>
                    <br/>
                       All rights Reserved &middot; 2022
           
                   </h5>
                   <p><br><br><br></p>
           
           </body>
           
           </html>
           
           ';
            $mail->msgHTML($body);
            $mail->AltBody = 'This is a plain text message body';
            if ($mail->send()) {

                return redirect()->route('admin.appointment');
            } else {
                return redirect()->back()->with('error', 'Unable to send email.');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function notifyusers(Request $request){
       $selected = $request->selected;
        $doa = $request->doa;
        $timestart = $request->timestart;
        $timeend   = $request->timeend;

       foreach($selected as $users){
            $u = User::findorFail($users);
            $email = $u->email;
            $name  = $u->name;

            $this->token = session()->get('token');
            $mail = new PHPMailer(true);
    
            try {
                $mail->isSMTP();
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 465;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->SMTPAuth = true;
                $mail->AuthType = 'XOAUTH2';
                $mail->setOAuth(
                    new OAuth(
                        [
                            'provider'          => $this->provider,
                            'clientId'          => $this->client_id,
                            'clientSecret'      => $this->client_secret,
                            'refreshToken'      => $this->token,
                            'userName'          => session()->get('email')
                        ]
                    )
                );
    
                $mail->setFrom(session()->get('email'), session()->get('e_name'));
                $mail->addAddress($email, $name);
                $mail->Subject = 'Dr.'.Auth::user()->name;
                $mail->CharSet = PHPMailer::CHARSET_UTF8;
                $body = '<!DOCTYPE html>
               <html lang="en">
               
               <head>
                   <meta charset="UTF-8">
                   <meta name="viewport" content="width=device-width, initial-scale=1.0">
                   <meta http-equiv="X-UA-Compatible" content="ie=edge">
                   <title></title>
               </head>
               
               <body style="background-color: white">
               <p><br><br><br></p>
                   <h2><a target="_blank" href="#">Patient Appointment Scheduling  Management System</a></h2>
               
                   <h3 style="color:rgb(14, 87, 136)">Hi ' . $name . '!
               
                
                       </h3>
                       <h4> Dr. ' . Auth::user()->name . ' has set you an appointment,  Please be at the hospital at the stated date and time below. </h4>
    
    
                       <br>
                       <h5>

                       Appointment Details : <br/>
                       Date and time : '.date('F j,Y',strtotime($doa)).'
                        <br><br>
                       Time  : '.date('h:i a',strtotime($timestart)).' - '.date('h:i a',strtotime($timeend)).'
                           <br>
                        <span style="color:red">Have a great day.</span>
                        <br/>
                           All rights Reserved &middot; 2022
               
                       </h5>
                       <p><br><br><br></p>
               
               </body>
               
               </html>
               
               ';
                $mail->msgHTML($body);
                $mail->AltBody = 'This is a plain text message body';
                if ($mail->send()) {
    
                 
                } else {
                   
                }
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
            }

       }




       return redirect()->route('admin.appointment')->with('Success','Appointment has set and user has been notified');

       
 
    }
}
