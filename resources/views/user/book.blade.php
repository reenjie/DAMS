@extends('layouts.user_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">My Appointments</h4>         
        </div>

        <div class="row">
          <div class="card">
            <div class="card-header">
              <button class="btn btn-success btn-sm" onclick="window.location.href='/Schedules'">Book For Appointment <i class="fas fa-arrow-right"></i></button>
            </div>
            <div class="card-body">
              <ul class="nav nav-tabs" id="myTab" role="tablist" style="font-size:14px">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">My Appointments</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-info" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Histories</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-danger" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Cancelled/Disapproved</button>
                </li>
              
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                  @include('user.allappt')
                </div>
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                  <br>
                  @include('user.history')
                </div>
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                  @include('user.cancelled')
                </div>
                <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
              </div>
            </div>
          </div>
           
        </div>

    @if(Session::get('Success'))
    <script>
        swal("Appointment Booked Successfully!", "Your request is still pending, and waiting for approval.", "success");
     </script>
       
    @endif
    <script>
        $('#booknow').submit(function(){
         $('#submit').html('Submitting ..');
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




$('#dop').change(function(){
    var val = $(this).val();
    var id = $('#clinic').val();
    $(this).removeClass('is-invalid');
    $('#submit').removeAttr('disabled');

    $.ajax({
 url : '{{route("home.checkifexist")}}',
 method :'get',
 data : {value:val,id:id},
 success : function(data){
    if(data == 'Reserved'){
        $('#dop').addClass('is-invalid');
        $('#submit').attr('disabled',true);
    }
 }
})
})

$('#clinic').change(function(){
    var id = $(this).val();
    var val = $('#dop').val();

    if(val == ''){
 $('#dop').addClass('is-invalid');
 $('#submit').attr('disabled',true);
    }else {
        $.ajax({
 url : '{{route("home.checkifexist")}}',
 method :'get',
 data : {value:val,id:id},
 success : function(data){
    if(data == 'Reserved'){
        $('#dop').addClass('is-invalid');
        $('#submit').attr('disabled',true);
    }
 }
})
    }
   


   
})

</script>
@endsection