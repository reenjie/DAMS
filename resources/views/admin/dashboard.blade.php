@extends('layouts.admin_layout')
@section('content')
    <div class="container" style="">
        <div class="titlebar">
            <h4 class="hf mb-3">Dashboard</h4>
            

        </div>
        @if(Session::has('upt'))
        <script>
            swal ( "Updated!" ,  "Account updated successfully!" ,  "success" )
        </script>
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="card shadow" style="height: 100px;border-left:10px solid rgb(121, 146, 179);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold" >
                           Appointments
                             
                             
                         </h5>
                        <span class="badge bg-danger">{{count($allnew)}}</span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">
                           
                            <i class="fas fa-clipboard-list text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card shadow bg-light" style="height: 100px;border-left:10px solid rgb(73, 133, 86);border-bottom:1px dashed gray" >
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold" >
                           Schedules
                            
                            
                        </h5>
                        <span class=" badge bg-danger">{{count($schedule)}}</span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">
                            
                            <i class="fas fa-clock text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </div>


            <div class="col-md-3">
                <div class="card shadow" style="height: 100px;border-left:10px solid rgb(63, 116, 194);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold" >
                          Patients
                             
                         </h5>
                        <span class="badge bg-danger">{{count($Patients)}}</span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">
                            
                            <i class="fas fa-users text-secondary"></i>
                        </h1>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow" style="height: 100px;border-left:10px solid rgb(194, 63, 96);border-bottom:1px dashed gray">
                    <div class="card-body">
                        <h5 class="text-primary af" style="font-weight:bold" >
                          Referred
                             
                             
                         </h5>
                        <span class="badge bg-danger">{{count($feedback)}}</span>
                        <h1 style="position: absolute;right:10px;top:0;padding:10px">
                            <i class="fas fa-sync text-secondary"></i>
                           
                        </h1>

                    </div>
                </div>
            </div>
            
         
        </div>

        <div class="row mt-4">
            
            <div class="col-md-8">
                @if(count($refer)>=1)
                <div class="card shadow border-danger mb-2 bg-danger">
                   
                    <div class="card-body">
                        <h5 class="hf text-light style="text-align: center">{{count($refer)}} New Referral! </h5>
                        <br>
                        <a href="{{route('admin.referral')}}" class="btn btn-light btn-sm">View All</a>
                    </div>
                </div>
                   @else
                    <div class="card shadow mb-2 p-4 d-flex  " >
                        <div class="justify-content-center">
                            <div style="display: flex">
                                <img src="{{asset('img/notfound.svg')}}" style="width: 250px" alt="">
                                <h6 class="mt-10 " style="font-weight: bold;margin-top:100px;margin-left:40px">No Referrals Found ..</h6>

                            </div>
                           
                        </div>
                    </div>
                @endif
              

                <div id="chartContainer" style="height: 300px; width: 100%;"></div>
        <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

       
            </div>

            <div class="col-md-4">
          

               

                  <div class="card shadow mt-2">
                    <div class="card-header">
                        <h6 class="text-primary">
                            New Appointments
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach ($data as $row)
                            <li class="list-group-item">

                                <span style="font-size:12px">Patient Transaction# {{$row->id}}</span>
                                <br>
                                @foreach ($user as $patient)
                                @if($row->user_id == $patient->id)
                                {{$patient->name}}
                            <br>
                          
                                
                           
                            <span class="text-secondary" style="font-size:13px">{{$patient->email}}</span>
                            <br>
                            <span class="text-secondary" style="font-size:13px">{{$patient->contactno}}</span>
                                @endif
                            @endforeach
                            </li>
                            @endforeach
                          
                           
                          </ul>
                          <a href="{{route('admin.appointment')}}" class=" mt-2 btn btn-link btn-sm">View all</a>
                    </div>
                  </div>

            </div>
        </div>


    </div>
  
     

    {{-- <script>
        window.onload = function () {
        
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "Doctors and Appointments"
            },
            axisY: {
                title: "Appointment Bookings"
            },
            data: [{        
                type: "column",  
                showInLegend: true, 
                legendMarkerColor: "grey",
                legendText: "Doctors",
                dataPoints: [      
                 
                    @foreach ($Doctor as $row)
                   
         

                 @php
            $count = DB::select('select * from appointments where doctor ='.$row->id.' ');
                 @endphp
        
        { y: {{count($count)}}, label: "Dr. {{$row->firstname.' '.$row->lastname}}" },
                @endforeach

                ]
            }]
        });
        chart.render();
        
        }
        </script> --}}
@endsection