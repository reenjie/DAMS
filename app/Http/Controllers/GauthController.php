<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use Google_Client;
use Google_Service_Oauth2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class GauthController extends Controller
{
   

    public function redirectToGoogle()
    {
      //https://patientappointment.hostedcom.online/google/callback
       
        $client = new Google_Client();
        $client->setApplicationName('My Laravel App');
        $client->setAuthConfig(public_path('client_secret.json'));
        $client->setRedirectUri('https://patientappointment.hostedcom.online/google/callback');
     //  $client->setRedirectUri('http://localhost:8000/google/callback');
        $client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
        $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new Google_Client();
        $client->setApplicationName('My Laravel App');
        $client->setAuthConfig(public_path('client_secret.json'));
        $client->setRedirectUri('https://patientappointment.hostedcom.online/google/callback');
     //$client->setRedirectUri('http://localhost:8000/google/callback');
        $client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
        $client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

        $code = $request->get('code');
        $token = $client->fetchAccessTokenWithAuthCode($code);
        $client->setAccessToken($token['access_token']);

        $oauthService = new Google_Service_Oauth2($client);
        $user = $oauthService->userinfo->get();
        $email = $user->email;
        $lastname = $user->familyName;
        $firstname = $user->givenName;
       
        $user = User::where('email',$email)->get();
        if(count($user)>=1){
          if(Auth::loginUsingId([$user[0]->id])){
            return redirect()->route('home');
          }else{
         return redirect('/');
          }

        }else{
            $reg = User::create([
            'name' =>$firstname.' '.$lastname,
            'email' => $email,
            'address' => '',
            'contactno' =>'',
            'user_type' => 'patient',
            'password' => Hash::make('password'),
            'fl'=>1,
            'otp'=>1,     
            ]);  

          
              if(Auth::loginUsingId([$reg->id])){
                return redirect()->route('home');
              }else{
                return redirect('/');
              }


        }
       
    }

   
}
