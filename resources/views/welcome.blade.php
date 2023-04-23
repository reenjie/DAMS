<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{$title}}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}"
    >
    <link rel="stylesheet" href="{{asset('css/admin.css')}}"
    >
    <link rel="stylesheet" href="{{asset('css/home.css')}}"
    >
    <link rel="stylesheet" href="{{asset('css/mobile.css')}}"
    >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  
</head>

<body style="">
<style>
    body{
        background-color: rgb(255, 255, 255);
    }
</style>

 



    <div class="banner mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="row"> 
                      
                        <div class="col-md-5">
                            <div class="container">
                                <div class="card p-2  mt-5" id="logincard">
                               
                                   
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}" autocomplete="off">
                                            @csrf
                                        <h6 class="text-success" style="text-transform:uppercase;font-weight: bold;text-align:center">Sign In</h6>
                                @if(session()->has('saveappt'))
                                  <span style="font-size:13px" class="badge bg-danger">
                                    Please Login First to Book your appointment schedule.
                                  </span>
                                
                                @endif
                                        <div class="container mt-4">
                                            <h6 style="font-size:15px;">Email:</h6>

                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-user text-secondary"></i></span>
                                                <input required type="text"
                                            style="font-size:14px" class="form-control @error('email') is-invalid @enderror " autofocus name="email" value="{{ old('email') }}">
                                            
                                        </div>
                                        @error('email')
                                       
                                           <span style="font-size:12px" class="text-danger mb-2" role="alert">
                                               <strong>{{ $message }}</strong>
                                           </span>
                                       @enderror   
                                            
                                       
                                      
                                            <h6 style="font-size:15px">Password:</h6>
                                            <div class="input-group mb-3">
  <span class="input-group-text" id="basic-addon1"><i class="fas fa-key text-secondary"></i></span>
  <input required  style="font-size:14px"  type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
</div>
                                          

                                            @error('password')
                                            <span style="font-size:12px" class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                           
                                            <a href="{{ route('password.request') }}" class="mt-5" style="text-decoration: none;font-size:14px">Forgot Password?</a>
                                            <button class="mt-3 py-2 mb-2 form-control btn btn-success" style="text-transform:uppercase">Login</button>
                                            <br>
                                            <a href="{{ route('google.login') }}" class="btn btn-danger form-control"  style="text-transform:uppercase">Sign in with Google</a>
                                            <br>

                                            <a href="{{route('register')}}" class="mt-5" style="text-decoration: none;font-size:14px">Register Here</a>
                                     
                                        </div>
                                    </form>
                                    </div>
                                </div>     
                            </div>
                      

                        </div>

                        <div class="col-md-1"></div>
                        <div class="col-md-6 mb-5" id="bannerbg">
                            <img src="{{asset('img/bann.svg')}}" class="imgbanner" width="100%" alt="">
                            <br>
                            <h1 style="text-transform:uppercase;text-align: center;font-weight:bold;color:#269444">
                               Patient Appointment 
                                    
                               
                            </h1>
                            <h4 style="text-align: center;color:rgb(93, 95, 107);font-weight:bold">
                            Scheduling Management System
                            </h4>
   
                            <div class="btns">
                               
                                <button onclick="window.location.href='/Schedules'" style="background-color:gray" class="btnbook">
                                   Book Now
                                </button>

                                <button onclick="window.location.href='/Doctors'" class="btnbook">
                                  Doctors
                                </button>

                            
                            </div>
                        

                           
                        </div>
                       
                    </div>


                </div>
                <div class="col-md-1"></div>
             
            </div>
        </div>
       
    </div>
       

    <span id="footer">Patient Appointment Scheduling MS &middot; All rights Reserved | 2023</span>
               


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="canvasbody">

        </div>
    </div>
    @if (session('Success'))
        <script>
            swal("Your Password Changed Successfully!", "You can now login . Thank you for using our website!",
                "success");
        </script>
    @endif

    <script>
        function reveal() {
            var reveals = document.querySelectorAll(".reveal");
            for (var i = 0; i < reveals.length; i++) {
                var windowHeight = window.innerHeight;
                var elementTop = reveals[i].getBoundingClientRect().top;
                var elementVisible = 150;
                if (elementTop < windowHeight - elementVisible) {
                    reveals[i].classList.add("active");
                } else {
                    reveals[i].classList.remove("active");
                }
            }
        }

        window.addEventListener("scroll", reveal);

        // To check the scroll position on page load
        reveal();
        $('#btnbars').click(function() {
            $('.tabs ul').attr('style', 'display:inline-block;z-index:1');
        })
        var nav = $('.tabs').html();
        $('#canvasbody').html(nav);

        $('#submitbtn').click(function() {
            $('.txtbox').val('');

            swal("Thanks for Sending Message!", "We get back to you Soon!", "success")
        })
    </script>
   



</body>

</html>
