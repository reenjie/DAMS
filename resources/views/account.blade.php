<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Doctor Appointment-MS</title>

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
    
    </head>
    <body style="background-color: #F1DBBF">
     
       {{--     --}}

       <nav class="shadow" style="background-color:#698269">
       

       

        <button id="btnbars" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" ><i class="fas fa-bars"></i></button>

    </nav>

                 

                <div class="main-book ">
         
                      <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                   <div class="card shadow mt-3 bg-light">
                        <div class="card-body">
                        <form action="{{route('edit.updateaccount')}}" method="post" autocomplete="off" enctype="multipart/form-data">
                                    @csrf
                        @php
            $usertype = Auth::user()->user_type;
        switch ($usertype) {
          case 'superadmin':
           $route = route("superadmin.dashboard");
            break;

            case 'doctor':
          $route = route("admin.dashboard");
              break;

              case 'patient' :
              $route = route('user.dashboard');
              break;
       
                         }
                        @endphp
                          <a href="{{$route}}">Back to Dashboard</a>
                         
                         <h5 class="hf mt-2">My Account</h5>

                         @if(Auth::user()->image == null)
                         <img src="https://img.freepik.com/free-icon/user_318-875902.jpg?w=2000" alt="" class="img-thumbnnail shadow rounded-circle"
                         style="width: 60px;height: 60px;border-radius: 30px;">
                         @else 
                         <img src="{{asset('public/profile'.'/'.Auth::user()->image)}}" alt="" class="img-thumbnnail shadow rounded-circle"
                         style="width: 60px;height: 60px;border-radius: 30px;">

                         @endif

                         <input type="file" accept="image/*" name="userimage">
                         <br>
                         <span style="font-size:12px" class="text-danger">Select Image file to update profile</span>
                         <br><br>
                         
                         <span class="af" style="font-size:14px">Email:</span>
                         <input type="email" class="form-control mb-2 " disabled value="{{Auth::user()->email}}">

                         <span class="af" style="font-size:14px">Name:</span>
                         <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}">

                         <span class="af" style="font-size:14px">Address:</span>
                         <input type="text" name="address" class="form-control" value="{{Auth::user()->address}}">

                         <span class="af" style="font-size:14px">Contact No:</span>
                         <input type="number" name="contactno" class="form-control" value="{{Auth::user()->contactno}}">

                         <span class="af" style="font-size:14px">Password:</span>
                         <input type="password" onclick="$(this).val('')" class="form-control" name="password" value="{{Auth::user()->password}}" autocomplete="off">
                         <span style="font-size:12px" name="password" class="text-danger">Put a Value to update the password</span>

                         <br>
                         <button class="btn btn-success btn-sm mt-5">UPDATE ACCOUNT</button>
                        </form>


                        </div>
                   </div>

                        </div>
                        <div class="col-md-3"></div>
                      </div>

                   
                          
                      </div>
            {{-- 
                      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                         
                          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="canvasbody">
                        
                        </div>
                      </div> --}}
              <script>
                       $('#booknow').submit(function(){
                        $('#submit').html('submitting ..');
                       })
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

            $('#clinic').change(function(){
              var val = $(this).val();
            if(val == ''){
              $('#doctor').html('<select name="Doctor" class="authbox form-select @error("Doctor") is-invalid @enderror"  id="" disabled></select> ');
              $('#category').html('<select name="Category" class="authbox form-select @error("Category") is-invalid @enderror" id="" disabled> </select>  ');
            }
              $(this).removeClass('is-invalid');
              $.ajax({
                url : '{{route("home.category")}}',
                method :'get',
                data : {sortby:val},
                success : function(data){
                 $('#category').html(data);
                 $('#doctor').html('<select name="Doctor" class="authbox form-select  id="" disabled></select> ');
                }
              })
            })

          




              </script>

    </body>
</html>
