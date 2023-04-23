<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Letter of Agreement</title>

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
    <body style="background-color:#e6eeff">
     
    

    

                 

                <div class="main-book ">
         
                      <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6 reveal">
                            @php
                            $agree = DB::select('SELECT * FROM `agreements`');
                            @endphp
                        <p>
                                @foreach($agree as $item)
                               
                                <textarea name="" style="width:100%;height:auto;outline:none;border:none;background-color:transparent;resize:none;" readonly id="" cols="30" rows="10">{{$item->content}}</textarea>
                                @endforeach
                        </p>

                        </div>
                        <div class="col-md-3"></div>
                      </div>

                   
                          
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
