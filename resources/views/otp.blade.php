<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Patient Appointment Scheduling-MS</title>

  <!-- Fonts -->
  <!-- Fonts -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link rel="stylesheet" href="{{asset('css/admin.css')}}">
  <link rel="stylesheet" href="{{asset('css/home.css')}}">
  <link rel="stylesheet" href="{{asset('css/mobile.css')}}">
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

<body style="background-color: #F1DBBF">
  <div class="container mt-4">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <style>
          #otp::placeholder {

            letter-spacing: 5px;
            text-align: center
          }

          #otp {
            font-size: 25px;
          }
        </style>
        <div class="card shadow ">
          <div class="card-body p-5">
            <div style="text-align: center" class="mb-5">

            </div>
            <h5 class=" text-dark" style="font-weight: bold">
              We have sent your <span style="font-size: 24px;">OTP</span> (One Time Pin)
              <span style="font-size: 15px;"><br /> to your Email
                <span style="color:rgb(204, 60, 60)">
                  {{

 preg_replace('/(?<=.).(?=.*@)/', '*', Auth::user()->email);
                                        }}
                </span>

              </span>.
            </h5>

            <form action="{{route('verifyotp')}}" method="post">
              @csrf

              <input autofocus class="form-control @if(session()->has('error'))
is-invalid
@endif  py-3" style="text-align:center" name="otp" placeholder="" id="otp" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
              <div class="invalid-feedback">
                You have Entered an Incorrect Pin!
              </div>

              <button type="submit" class="btn btn-success mt-3 p-2 px-3" style="float: right;font-weight:bolder">SUBMIT</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>


</body>

</html>
