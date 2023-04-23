@extends('layouts.user_layout')
@section('content')
<div class="dropdown">
    <button style="float: right;margin-right:20px" class="shadow btn btn-light btn-sm mb-2 text-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Appointments <i class="fas fa-list"></i>
    </button>
    <ul class="dropdown-menu">
    
            <li><a class="dropdown-item" style="font-size: 13px" href="{{route('user.view_pending')}}">Pending</a></li>
            <li><a class="dropdown-item" style="font-size: 13px" href="{{route('user.view_approved')}}">Approved</a></li>
            <li><a class="dropdown-item" style="font-size: 13px" href="{{route('user.view_completed')}}">Completed</a></li>
            <li><a class="dropdown-item" style="font-size: 13px" href="{{route('user.view_disapproved')}}">Disapproved</a></li>
            <li><a class="dropdown-item" style="font-size: 13px" href="{{route('user.cancelled')}}">Cancelled</a></li>
    </ul>
  </div>
    <div class="container">

        <div class="titlebar">
            <h4 class="hf mb-3">View Appointment</h4>         
        </div>
        <span class="badge bg-danger mb-2" style="text-transform:uppercase">Disapproved</span>

        <div class="row">
            <div class="col-md-8">

                @if(Session::get('Success'))
                <div class="row">
                
                 <div class="col-md-12">
                     <div class="alert alert-success alert-dismissible fade af show" role="alert">
                        {{Session::get('Success')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 </div>
                </div>
                
             @endif
                @if(count($data)>=1)
                @foreach ($data as $row)
                               <div class="card shadow mb-2 searchfilter">
                                   <div class="card-header">
                                      <h6  style="font-size:12px"><span>Transaction# {{$row->id}}</span></h6> 
                                      @php
                                          $resenddate = date('Y-m-d H:i:s',strtotime($row->updated_at.'+1 day'));

                                          $rsd = date('Y-m-d H:i:s',strtotime($row->updated_at.'+1 day'));
                                       
                                          $currentdate = date('Y-m-d H:i:s');
                                      @endphp
                                    
                                      @if($currentdate > $resenddate)
                                      <button data-id="{{$row->id}}" style="" class="btnresend btn btn-primary btn-sm">Resend</button>
                                      
                                      @else
                                      <button style="" class="btn btn-secondary disabled btn-sm" >Resend</button>
                                   
                                      @php
                          $resendtime = date("M j, Y H:i:s", strtotime($rsd));
                                      @endphp
                                    <span class="text-danger" style="font-size:13px" >Resend Time Remaining : <span style="font-weight: bolder" id="demo">-- : -- : -- : --</span> </span>
                                   
                                    <script>
   
                                        var countDownDate = new Date("{{$resendtime}}").getTime();
                                        
                                      
                                        var x = setInterval(function() {
                                        
                                         
                                          var now = new Date().getTime();
                                            
                                            
                                          var distance = countDownDate - now;
                                            
                                         
                                          var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                          var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                          var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                          var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                            
                                        
                                          document.getElementById("demo").innerHTML = days + " days : " + hours + " hours : "
                                          + minutes + " minutes: " + seconds + " Seconds ";
                                            
                                         
                                          if (distance < 0) {
                                            clearInterval(x);
                                            document.getElementById("demo").innerHTML = "";
                                            location.reload();
                                          }
                                        }, 1000);
                                        </script>
                                      @endif
                                       
                                      <button data-id="{{$row->id}}" style="float: right;" class="btnresend btn btn-light text-danger btndelete btn-sm">Delete</button>

                                   </div>
                                   <div class="card-body">

               
                                       <div class="row">
                                     
                                           <div class="col-md-12">
                                               <h6 class="af" style="text-align: left">
                                                @if($currentdate > $resenddate)
                                                <span style="font-size:14px"> Appointment Date </span> : 
                                                  
                                                <input type="date" class="form-control" id="{{$row->id}}dop" value="{{$row->dateofappointment}}">
                                                <br>
                                                <span style="font-size:14px"> Time </span> : 
                                                <input id="{{$row->id}}top" type="time" class="form-control" value="{{$row->timeofappointment}}">
                                                @else
                                                <span style="font-size:14px"> Appointment Date </span> : 
                                                  
                                                <span class="text-danger">{{date('F j,Y',strtotime($row->dateofappointment))}}</span>
                                                <br>
                                                <span style="font-size:14px"> Time </span> : <span class="text-danger">{{date('h:i a',strtotime($row->timeofappointment))}}</span>
                                                @endif
                                                
                                                   <br><br>
                                                   <span style="font-size:14px"> Doctor </span> : <br>
                                                   @foreach ($Doctor as $doc)
                                                       
                                                   @if($doc->id == $row->doctor)
                                                   @php
                                                       $doctorname = $doc->firstname.' '.$doc->lastname;
                                                   @endphp
                                                   <span class="text-primary">Dr. {{$doc->firstname.' '.$doc->lastname}}</span> 
                                                   @if($doc->isavailable == 1)
                                                   <span style="font-size:11px" class="text-danger">(Unavailable)</span>
                                                   @endif
                                                   <br>
                                                   <span class="text-secondary" style="font-size:14px" >
                                                     {{$doc->email}}
                                                       <br>
                                                      {{$doc->contact}}
                                                   </span>
               
                                                   @endif
                                                   @endforeach

                                                   <br>
                                                   <br>
                                                   Clinic Information
                                                   <br>
                                                   <span style="color:gray">
                                                

                                                    @php
                                                        $cl = DB::select('select * from clinics where id = '.$row->clinic.' ');
                                                    @endphp
                                                    @foreach ($cl as $item)
                                                       <span class="text-primary">
                                                        {{$item->name}}    
                                                    </span> 
                                                    <br>
                                                    <span style="font-size: 12px">{{$item->street.' '.$item->barangay.' '.$item->city}}</span>
                                                    @endforeach
                                                   </span>
                                                    <br>

                                                    <span class="text-secondary"  style="font-size:14px">
                                                        <br>
                                                        Purpose :
                                                        <br>
                                                        {{$row->purpose}}
                                                     
                                                      </span>
                                               </h6>
                                             

                                               <br>
                                               <span class="text-secondary" style="font-size:12px">
                                                Remarks:
                                                <br>
                                              <span class="text-danger">{{$row->remarks}}</span>  
                                               </span>
                                     
                                            
                                           </div>
                                       </div>
                                      
                                   </div>
                                   <div class="card-footer">
                                    <h6 style="font-size:13px">Status: <span class="badge text-bg-danger" style="padding: 5px;font-size:12px">Disapproved</span> </h6>
                                  
                                   </div>
                               </div>
                               @endforeach 
                               @else 
                               <h6 style="text-align: center" class="af">
                                   <img src="https://image.freepik.com/free-vector/no-data-concept-illustration_114360-626.jpg" class="img-fluid" alt="">
                                   <br>
                                   No Appointment yet..
                               </h6> 
                               @endif
               
               
                             
                             

            </div>
        </div>

            
    </div>
  
    <script>
        $('.btnresend').click(function(){
            var id = $(this).data('id');
            var dop = $('#'+id+'dop').val();  
            var top = $('#'+id+'top').val();  
         
        swal({
  title: "Are you sure?",
  text: "Your request will be verified first.",
  icon: "warning",
  buttons: true,
  dangerMode: false,
})
.then((willDelete) => {
  if (willDelete) {
    window.location.href='{{route("edit.resend")}}'+'?id='+id+'&dop='+dop+'&top='+top;
  } else {
  
  }
});
        })

        $('.btndelete').click(function(){
            var id = $(this).data('id');
            swal({
        title: "Are you sure?",
        text: "You cannot undo action.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            window.location.href='{{route("delete.delete_appt")}}'+'?id='+id;
        } else {
        
        }
});

        })
    </script>
@endsection