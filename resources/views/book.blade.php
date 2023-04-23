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
    <body style="background-color: rgb(255, 255, 255)">
     
       {{--     --}}

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
        <button id="btnbars" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" ><i class="fas fa-bars"></i></button>

    </nav>

                 

                <div class="main-book ">
         
                      <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                          <form method ="post" action="{{route('home.submit')}}" id="booknow">
                            @csrf
                                    <div class="container mb-5 mt-4 " style="background-color: rgba(243, 243, 243, 0.185)">
                                     <div class="card-body login">
                                      @if(Session()->has('cannotbe'))
                                      <div class="alert alert-danger">
                                        <h6>{{Session()->get('cannotbe')}}</h6>
                                      </div>
                                      @endif
                                                <h5 style="font-weight: bolder;color:rgb(69, 69, 117)">Book an Appointment</h5>
                                                <div class="row">
                                <div class="col-md-6">
                          
                             <label for="">Date :</label>
                            @php
                                $date = date('Y-m-d');
                            @endphp
                           <input type="date" name="dateofappointment" class="form-control mb-2" placeholder="" value="{{old('dateofappointment')}}" autofocus required min="{{date('Y-m-d',strtotime(date("Y-m-d", strtotime($date)) . " +1 day"))}}" >
                                 </div>
                                 <div class="col-md-6">
                                    <label for="">Time :</label>
                                    <input type="time" name="timeofappointment" class="form-control " placeholder="" value="{{old('timeofappointment')}}" required>

                        </div>

                        <div class="col-md-12">
                          <label for="">Purpose :</label>
                          <textarea name="purpose" class="form-control mb-2" id=""  rows="5" placeholder="Type your purpose.." required></textarea>
                        </div>

                                    <div class="col-md-6">
                            <label for="">Clinic :</label>
                          <select name="Clinic" class=" form-select @error('Clinic') is-invalid @enderror" id="clinic" >
                            <option value="">Select Clinic</option>
                            @foreach ($clinic as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option> 
                            @endforeach
                                              
                        </select> 
                        @error('Clinic')
                          <div class="invalid-feedback">
                            <span style="font-size:12px">Please Select Clinic</span>
                          </div>
                        @enderror
                                    </div>
                         <div class="col-md-6">
                            <label for="">Specialization :</label>
                            <div id="category">
                              <select name="Category" class=" form-select @error('Category') is-invalid @enderror" id="" disabled>
                              
                                           
                    </select>    
                    @error('Category')
                    <div class="invalid-feedback">
                      <span style="font-size:12px">Please Select Specialization</span>
                    </div>
                  @enderror
                            </div>
                         
                                    </div>

                         <div class="col-md-12">
                            <label for="">Doctor :</label>
                            <div id="doctor">
                          <select name="Doctor" class=" form-select  @error('Doctor') is-invalid @enderror" id="" disabled>
                                               
                        </select>   
                        @error('Doctor')
                        <div class="invalid-feedback">
                          <span style="font-size:12px">Please Select your Doctor</span>
                        </div>
                      @enderror 
                      </div>
                                    </div>
                            <div class="col-md-12">
                          <button type="submit" id="submit" class="btn btn-primary form-control mt-4 py-3">SUBMIT</button>
                                    </div>
                               
                                             </div>
                                       
                                             

                                      </div>
                                    </div>
                                  </form>

                        </div>
                        <div class="col-md-3"></div>
                      </div>
{{-- 
                        <footer class="">
                                <h5 class="" style="text-align:center">
                                    All rights Reserved &middot; 2022
                                 
                                   
                                </h5>
                           
                                
                        </footer> --}}
                   
                          
                      </div>
            
                      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header">
                         
                          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body" id="canvasbody">
                        
                        </div>
                      </div>
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
              $('#category').html('<select name="Category" class=" form-select @error("Category") is-invalid @enderror" id="" disabled> </select>  ');
            }
              $(this).removeClass('is-invalid');
              $.ajax({
                url : '{{route("home.category")}}',
                method :'get',
                data : {sortby:val},
                success : function(data){
                 $('#category').html(data);
                 $('#doctor').html('<select name="Doctor" class=" form-select  id="" disabled></select> ');
                }
              })
            })

          




              </script>

    </body>
</html>
