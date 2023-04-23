@extends('layouts.user_layout')
@section('content')
<div class="container">



    @if (session()->has('Error'))
    <script>
        swal("Booking Unsuccessful!", "You have already set an appointment on your selected Schedules!", "error").then(() => {
            location.reload();
        });
    </script>

    {{session()->forget('saveappt')}}
    @endif
    @if(session()->has('Successbooked'))
    <script>
        swal("Booked Successfully!", "Your request is still pending, and waiting for approval.", "success").then(() => {
            location.reload();
        });
    </script>
    {{session()->forget('saveappt')}}
    @endif


    <div class="titlebar">
        <h4 class="hf mb-3">Dashboard</h4>


    </div>

    @if (Session::has('upt'))
    <script>
        swal("Updated!", "Account updated successfully!", "success")
    </script>
    @endif

    @if(Session::has('accept'))
    <script>
        swal("Accepted!", "Appointment Accepted successfully!", "success")
    </script>

    @endif

    @if(Session::has('saveaccept'))
    <script>
        swal("Accepted!", "Appointment Schedule set and  Accepted successfully!", "success")
    </script>

    @endif



    <h5></h5>
    <div class="row">

        <div class="col-md-3">
            <a href="{{ route('user.book') }}" style="text-decoration:none">
                <div class="card shadow bg-light" style="height: 100px;border-left: 10px solid rgb(99, 178, 202);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold">
                            Pending


                        </h5>
                        <span class=" badge bg-danger">
                            @isset($pending)
                            {{ count($pending) }}
                            @endisset
                        </span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">

                            <i class="fas fa-circle-minus text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('user.book') }}" style="text-decoration:none">
                <div class="card shadow" style="height: 100px;border-left:10px solid rgb(81, 129, 87);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold">
                            Approved


                        </h5>
                        <span class="badge bg-danger">
                            @isset($approved)
                            {{ count($approved) }}
                            @endisset
                        </span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">

                            <i class="fas fa-check-circle text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </a>
        </div>





        <div class="col-md-3">
            <a href="{{ route('user.book') }}" style="text-decoration:none">
                <div class="card shadow" style="height: 100px;border-left:10px solid rgb(194, 63, 63);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold">
                            Cancelled

                        </h5>
                        <span class="badge bg-danger">
                            @isset($cancelled)
                            {{ count($cancelled) }}
                            @endisset
                        </span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">

                            <i class="fas fa-ban text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3">

            <div class="card shadow" style="height: 100px;border-left:10px solid rgb(168, 63, 194);border-bottom:1px dashed gray">
                <div class="card-body">
                    <h5 class="text-primary af" style="font-weight:bold">
                        Referred


                    </h5>
                    <span class="badge bg-danger">
                        @isset($referred)
                        {{ count($referred) }}
                        @endisset
                    </span>
                    <h1 style="position: absolute;right:10px;top:0;padding:10px">
                        <i class="fas fa-circle-arrow-right text-secondary"></i>

                    </h1>

                </div>
            </div>

        </div>


    </div>



    <div class="row mt-5">
        <div class="col-md-2">

        </div>
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    @if(count($resched)>=1)
                    @foreach ($resched as $row)
                    <div class="card shadow mb-2">
                        <div class="card-body text-secondary" style="font-size:14px">
                            @php
                            $schedule = DB::select('select * from schedules where doctorid ='.$row->doctor.' ');

                            // $doctor = DB::select('select * from users where id = '.$row->doctor.' ');
                            $doctorinfo = DB::select('select * from users where id = '.$row->doctor.' ')
                            @endphp

                            <span style="float:right">
                                @php
                                switch ($row->status) {
                                case '0':
                                echo '<span class="badge bg-warning">Pending</span>';
                                break;
                                case '1':
                                echo '<span class="badge bg-primary">Approved</span>';
                                break;
                                case '2':
                                echo '<span class="badge bg-danger">Cancelled</span>';
                                break;
                                case '3':
                                echo '<span class="badge bg-danger">Disapproved</span>';
                                break;
                                case '4':
                                echo '<span class="badge bg-success">Completed</span>';
                                break;

                                }
                                @endphp
                            </span>

                            <span style="font-weight:bold;text-transform:uppercase">
                                Appointment No: {{$row->id}}
                            </span>
                            @php
                            $count = DB::select('SELECT * FROM `records` where appointment = '.$row->id.' ');
                            @endphp
                            @if(count($count)>=1)
                            || <span class="" style="font-size: 11px;text-transform:uppercase;color:#FF6000">FOLLOW-UP</span>
                            @endif
                            <hr>
                            <h6 style="text-align:center;font-size:13px">-- Doctors Details --</h6>
                            <h6 class="text-primary">
                                @foreach ($doctorinfo as $user)

                                @php
                                $p_id = $user->id;

                                @endphp
                                Dr. {{$user->name}}
                                <br>
                                <span style="font-size:12px" class="text-secondary"> {{$user->email}} </span>
                                <br>
                                <span class="text-secondary" style="font-size:13px">

                                    {{$user->address}}


                                </span>

                                @endforeach
                            </h6>

                            <br>
                            <h6 style="text-align:center;font-size:13px">-- Appointment Details --</h6>

                            <h6 style="font-size:14px">Specialization : <span class="text-primary" style="font-weight:bold">
                                    @php
                                    $specs = unserialize($row->category);
                                    @endphp

                                    <ul class="list-group list-group-flush">

                                        @for ($i = 0; $i < count($specs); $i++) @php $spec=DB::select('select * from categories where id='.$specs[$i].' ');
     @endphp
       @foreach ($spec as $sp)
      
       <li class="list-group-item text-primary" > {{$sp->name}} </li>
    @endforeach
    @endfor
  </ul>
      
                              </span>
                             
                            </h6>
                            <h6 style="text-align:center;font-size:13px">-- Actions --</h6>
                            <h6 style="text-align: center"> 
                                <div class="card mb-5 mt-2 shadow" style="background-color: rgba(210, 233, 245, 0.185)">
                                    <div class="card-body login">
                                    
                                           <h6>Set a Schedule</h6>
                                           <div class="row">
                                             <table class="table table-sm table-striped ">
                                               <thead>
                                                <tr class=" table-success">
                                                 <th>Date of Appointment</th>
                                                 <th>Time Start</th>
                                                 <th>Time End</th>
                                                 <th>No. of Patients</th>
                                                 <th>Action</th>
                                                </tr>
                                               </thead>
                                               <tbody>
                                                 @foreach ($schedule as $item)
                                                 <tr>
                                                   <td>{{date('F j, Y',strtotime($item->dateofappt))}}</td>
                                                   <td>{{date('h:ia',strtotime($item->timestart))}}</td>
                                                   <td>{{date('h:ia',strtotime($item->timeend))}}</td>
                                                   <td>{{$item->noofpatients}}</td>
                                                   <td>
                                                     <form method ="post" action="{{route('edit.userrebook')}}" id="booknow">
                                                       @csrf
                                                    <input type="hidden" name="schedid" value="{{$item->id}}">
                                                    <input type="hidden" name="id" value="{{$row->id}}">
                                                     <button class="btn btn-success btn-sm" type="submit">Select</button>
                                                   </form>
                                                   </td>
                                                 </tr>
                                                 @endforeach
                                               </tbody>
                                             </table>
                                         
                              
                                           </div>
                                      
                                            

                                     </div>
                                   </div>
                            </h6>
                             
                          
                    
                    
                              </div>
                          </div>
                    @endforeach

                    @else 

                    <div style="text-align:center">
                      
                        <img src="https://cdn.iconscout.com/icon/free/png-256/data-not-found-1965034-1662569.png" alt="">
                        <h5>You dont have any appointment referred to another doctor.</h5>
                    </div>
                    @endif
                </div>
               </div>
            </div>

            <div class="col-md-2">
            
            </div>

        </div>
    </div>

    <script>

        $(' .btnaccept').click(function(){ var id=$(this).data('id'); var refdoctor=$(this).data('ref'); var refclinic=$(this).data('refclinic'); swal({ title: "Are you sure?" , text: "Once accepted, they will be expecting you on this date and time stated." , icon: "info" , buttons: true, dangerMode: false, }) .then((willDelete)=> {
                                            if (willDelete) {
                                            window.location.href='{{route("edit.accept_newSchedule")}}'+'?id='+id+'&doctor='+refdoctor+"&clinic="+refclinic;
                                            }
                                            });
                                            // alert('aww');
                                            })

                                            $('.btncancel').click(function(){
                                            var id =$(this).data('id');

                                            swal("Please Write a Remarks or Reason of Declining Your Appointment:", {
                                            content: "input",
                                            icon: "warning",
                                            dangerMode: true,
                                            })
                                            .then((value) => {
                                            if(value == ''){
                                            swal({
                                            title: "Remarks Required!",
                                            text: "Please provide a Remarks or Reason of Declining.",
                                            icon: "error",
                                            button: "Close",
                                            dangerMode: true,
                                            });
                                            }else {
                                            $(this).removeClass('btn-primary').addClass('btn-light').html('<span class="text-danger" style="font-size:12px">Declining..</span>');
                                            window.location.href='{{route("edit.cancel_appointment")}}'+'?id='+id+'&remarks='+value;


                                            }
                                            });

                                            /* swal({
                                            title: "Are you sure to Disapproved this Booking? ",
                                            text: "Patient can still resend the request after 1 day of disapproval",
                                            icon: "warning",
                                            buttons: true,
                                            dangerMode: true,
                                            })
                                            .then((willDelete) => {
                                            if (willDelete) {
                                            $(this).removeClass('btn-primary').addClass('btn-light').html('<span class="text-danger" style="font-size:12px">Disapproving..</span>');
                                            window.location.href='{{route("home.disapprove_booking")}}'+'?id='+id;
                                            } else {

                                            }
                                            }); */
                                            })
                                            </script>

                                            <script>
                                                window.onload = function() {

                                                    var chart = new CanvasJS.Chart("chartContainer", {
                                                        animationEnabled: true,
                                                        title: {
                                                            text: "Booking Update in Statistics"
                                                        },
                                                        data: [{
                                                            type: "pie",
                                                            startAngle: 240,
                                                            yValueFormatString: "=##0\"\"",
                                                            indexLabel: "{label} {y}",
                                                            dataPoints: [{
                                                                    y: @isset($approved) {
                                                                        {
                                                                            count($approved)
                                                                        }
                                                                    }
                                                                    @endisset,
                                                                    label: "Approved"
                                                                },


                                                                {
                                                                    y: @isset($cancelled) {
                                                                        {
                                                                            count($cancelled)
                                                                        }
                                                                    }
                                                                    @endisset,
                                                                    label: "Cancelled"
                                                                },
                                                                {
                                                                    y: @isset($pending) {
                                                                        {
                                                                            count($pending)
                                                                        }
                                                                    }
                                                                    @endisset,
                                                                    label: "Pending"
                                                                },

                                                                {
                                                                    y: @isset($referred) {
                                                                        {
                                                                            count($referred)
                                                                        }
                                                                    }
                                                                    @endisset,
                                                                    label: "Referred"
                                                                },
                                                                {
                                                                    y: @isset($disapproved) {
                                                                        {
                                                                            count($disapproved)
                                                                        }
                                                                    }
                                                                    @endisset,
                                                                    label: "Disapproved"
                                                                }
                                                            ]
                                                        }]
                                                    });
                                                    chart.render();

                                                }
                                            </script>
                                            @endsection
