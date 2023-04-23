@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
  {{--       @isset($data)
        <div class="col-md-6 login">
            <h1 class="mb-2">Appointment :</h1>

            <div class="row">
                <div class="col-md-6">
                    <label for="email" class="col-form-label text-md-end">DATE</label>
                    <br>
                    <h5 class="authbox"> {{ date('F j,Y',strtotime($data['dateofappointment'])) }} </h5>
                </div>
                <div class="col-md-6">
                    <label for="email" class="col-form-label text-md-end">TIME</label>
                    <br>
                  <h5 class="authbox"> {{ date('h:i a',strtotime($data['timeofappointment'])) }} </h5>
                </div>
            </div>

            <label for="email" class="col-form-label text-md-end">Doctor</label>
                    <br>
                    <h5 class="authbox">Dr. {{$doc_name}}</h5>
           
                    <label for="email" class="col-form-label text-md-end">Clinic</label>
                    <br>
                    <h5 class="authbox">{{$clinic_name}}</h5>
                    <label for="email" class="col-form-label text-md-end">Category</label>
                    <br>
                    <h5 class="authbox">{{$cat_name}}</h5>

        
        </div>
       @endisset --}}
        <div class="col-md-6 login" >
            @if(Session::has('book'))
            <h6 class="text-secondary">
                Please Login to Submit Booking.
            </h6>
            @endif
                <form method="POST" action="{{ route('login') }}" autocomplete="off">
        
                        @csrf
                        <h1>Login</h1>

                        
                     
                            <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <br>

                         
                                <input id="email" type="email" class="authbox @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus autocomplete="off">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                          
                      

                                    <br>
                            <label for="password" class="col-form-label text-md-end ">{{ __('Password') }}</label>
                                    <br>
                         
                                <input id="password" type="password" class=" authbox @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                           
                                  
                                <br><br>

                        
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    
                                    <label style="font-size:17px" class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                         
                          
                             
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                <br>
                             <button type="submit" class="authbtn mt-3">
                                    {{ __('Login') }}
                                </button>


                               

                                <a href="{{route('register')}}" class="btn btn-link" style="margin-left:5px">Register</a>

                        </div>
                    </form>
              
        </div>
    </div>
</div>
@endsection
