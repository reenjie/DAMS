<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Medical Clinic</title>

    <!-- Fonts -->
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

<body style="background-color: rgb(255, 255, 255)">

 

    <nav class="shadow">
        <div class="logo" onclick="window.location.href='..' ">
            <span class="">MD-Appointment
             
            </span>

        </div>
       
        <div class="tabs">
            <ul class="menutabs">
                <li onclick="window.location.href='..'" style="cursor: pointer"><a id="home"
                        href="..">Home</a>
                    <div class="line"></div>
                </li>
                <li>
                    <div class="dropdown">
                        <a href="/Clinics" class="">Clinics</a>


                        {{-- <ul class="dropdown-menu">

                            @foreach ($clinics as $item)
                                <li> <a href="" class="dropdown-item">{{ $item->name }}</a></li>
                            @endforeach
                        </ul> --}}
                    </div>
                    <div class="line"></div>
                </li>
                <li>


                    <div class="dropdown">
                        <a href="/Doctors" class="">Doctors</a>

{{-- 
                        <ul class="dropdown-menu">
                            @foreach ($doc as $item)
                                <li> <a href=""
                                        class="dropdown-item">Dr.{{ $item->firstname . ' ' . $item->lastname }}</a></li>
                            @endforeach
                        </ul> --}}
                    </div>
                    <div class="line"></div>
                </li>


                @if (Route::has('login'))

                    @auth
                        {{-- if loginn --}}
                        @if (Auth::user()->user_type == 'superadmin')
                            <a href="{{ route('superadmin.dashboard') }}" style="text-decoration: none;color:aliceblue">
                            @elseif(Auth::user()->user_type == 'admin')
                                <a href="{{ route('admin.dashboard') }}" style="text-decoration: none;color:aliceblue">
                        @endif


                        <span class="hf " style="font-size:25px">Hi! </span> <span class="hf"
                            style="text-transform:capitalize">{{ Auth::user()->name }}</span>

                        </a>
                    @else
                        {{-- <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a> --}}

                        {{-- @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                                @endif --}}
                    @endauth

                @endif


            </ul>
        </div>

        <button id="btnbars" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
            aria-controls="offcanvasRight"><i class="fas fa-bars"></i></button>

    </nav>

    <div class="banner mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <img src="{{asset('img/bann.svg')}}" class="imgbanner" width="100%" alt="">
                            <br>
                            <h1 style="text-align: center;font-weight:bold;color:rgb(236, 96, 119)">
                                MEDICAL CLINIC
                                    
                               
                            </h1>
                            <h4 style="text-align: center;color:rgb(93, 95, 107);font-weight:bold">
                                Appointment and Referral System
                            </h4>
                            <div class="btns">
                             
                            </div>
                           
                        </div>
                        <div class="col-md-6" style="margin-top: 120px;">
                                        <h3 style="font-weight:bold;color:rgb(78, 142, 226)">ABOUT US</h3>
                            <div class="container reveal" >
                              
                          <p style="color:rgb(59, 56, 56)">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni voluptate illo autem non id vel ipsa repellat, laborum molestias maiores explicabo esse laboriosam doloribus distinctio aspernatur iste doloremque neque ad.
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni voluptate illo autem non id vel ipsa repellat, laborum molestias maiores explicabo esse laboriosam doloribus distinctio aspernatur iste doloremque neque ad.
</p>
                            </div>
                      

                        </div>
                    </div>


                </div>
                <div class="col-md-1"></div>
             
            </div>
        </div>
       
    </div>
       
               
        <br><br>
  


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="canvasbody">

        </div>
    </div>
    @if (session('Success'))
        <script>
            swal("Your Password Changed Successfully!", "You can now login and feel free to give us some feedbacks. Thank you!",
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
