@extends('layouts.admin_layout')

@section('content')
<div class="container">
    <div class="titlebar">
        <h4 class="hf mb-3">Patients</h4>

    </div>

    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="container">
                    <div class="table-responsive">
                        <table class="table table-hover table-sm  af" style="font-size:14px;border-radius:13px" id="myTable">
                            <thead>
                                <tr class="table-success">

                                    <th scope="col">Name</th>

                                    {{-- <th scope="col" colspan="5">Appointment-Details</th> --}}
                                    <th scope="col">Email & Contact#</th>
                                    <th scope="col">No of Appointments</th>
                                    <th scope="col">Date-Created</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)

                                <tr>

                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}
                                        <br>
                                        #{{$row->contactno}}
                                    </td>
                                    <td>
                                        @php
                                        $count = 0;
                                        @endphp
                                        @foreach ($appt as $item)
                                        @if($item->user_id == $row->id)
                                        @php
                                        $count ++;
                                        @endphp


                                        @endif
                                        @endforeach


                                        <button data-bs-toggle="modal" data-bs-target="#apptdetails{{$row->id}}" class="btn btn-light text-primary btn-sm" style="font-size:13px">{{$count}}</button>


                                        <div class="modal fade" id="apptdetails{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog ">
                                                <div class="modal-content">


                                                    <div class="modal-body">
                                                        <button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        <br><br>
                                                        <h5 class="hf">Appointment-Details</h5>

                                                        @php
                                                        $userappt = DB::select('SELECT * FROM `appointments` where user_id= '.$row->id.' ');
                                                        @endphp

                                                        @foreach ($userappt as $ap)
                                                        <h6 style="font-size:13px" class="af mb-3 bg-light shadow p-3">
                                                            @if($ap->apptID)
                                                            @php
                                                            $sched = DB::select('select * from schedules where id = '.$ap->apptID.' ');
                                                            @endphp
                                                            <span style="float: right"> Date : <span style="font-weight: bold" class="text-danger">{{date('F j,Y',strtotime($sched[0]->dateofappt))}}</span>

                                                                <br>
                                                                Time : <span style="font-weight: bold" class="text-danger">{{date('h:i a',strtotime($sched[0]->timestart)).' - '.date('h:i a',strtotime($sched[0]->timeend))}}</span>
                                                            </span>
                                                            @else
                                                            <span class="badge bg-danger">RESCHEDULING</span>
                                                            @endif
                                                            <br><br><br>
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item">


                                                                    Status :
                                                                    @if($ap->status == 0)
                                                                    <span class="text-warning">Pending</span>
                                                                    @elseif($ap->status == 1)
                                                                    <span class="text-primary">Approved</span>
                                                                    @elseif($ap->status == 2)
                                                                    <span class="text-danger">Disapproved</span>
                                                                    @elseif($ap->status == 3)
                                                                    <span class="text-success">Completed</span>
                                                                    @elseif($ap->status == 4)
                                                                    <span class="text-success">Currently Referred</span>
                                                                    @elseif($ap->status == 5)
                                                                    <span class="text-success">Currently Referred</span>

                                                                    @endif

                                                                </li>

                                                                <li class="list-group-item">
                                                                    @php
                                                                    $docdata = DB::select('select * from users where id = '.$ap->doctor.' ');
                                                                    @endphp

                                                                    @foreach ($docdata as $doc)
                                                                    Type :
                                                                    <span style="font-weight: bold;font-size:15px;" class="text-primary mb-2">

                                                                        @php
                                                                        $specs = unserialize($doc->specialization);
                                                                        @endphp

                                                                        <ul class="list-group list-group-flush">

                                                                            @for ($i = 0; $i < count($specs); $i++) @php $spec=DB::select('select * from categories where id='.$specs[$i].' ');
     @endphp
       @foreach ($spec as $sp)
      
       <li class="list-group-item text-primary" > {{$sp->name}} </li>
    @endforeach
    @endfor
  </ul>
                                            </span> <br><br>
                                               Doctor : 
                                               <span  style="font-weight: bold;font-size:15px;" class="text-primary mb-2">Dr. {{$doc->name}}</span> <br><br>
                   
                                               Details :
                                               <br>
                                               Contact # : <span class="text-primary">{{$doc->contactno}}</span><br>
                                               Email : <span class="text-primary">{{$doc->email}}</span>
                                            @endforeach
                                          
                                               </li>
                                             
                                             </ul>
               
                                          
                                         
               
                                           
                                       </h6>  
                                      @endforeach
                                     
                                  </div>
                                  <div class="modal-footer bg-light" ></div>
                               
                              </div>
                              </div>
                          </div>
                        </td>
                     {{--    <td colspan="5">
                            <div class="card">
                                <div class="card-body">
                                  
                                    <h6 style="font-size:12px" class="af">
                                    Date :  <span style="font-weight: bold" class="text-danger">{{date('F j,Y')}}</span>

                                    <br>
                                    Time : <span style="font-weight: bold" class="text-danger">{{date('h:i a')}}</span>
                                    <br>
                                    <hr>
                                

                                    Type : 
                                    <span  style="" class="text-primary">Custom Appointment</span>
                                    </h6>
                                    <button data-bs-toggle="modal" data-bs-target="#apptdetails{{$i}}" class="btn btn-light text-primary btn-sm" style="font-size:13px">View More</button>


            <div class="modal fade" id="apptdetails{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                <div class="modal-content">
                   
                  
                    <div class="modal-body">    
                        <button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <br><br>
                        <h5 class="hf">Appointment-Details</h5>
                        <h6 style="font-size:13px" class="af">
                         <span style="float: right">   Date :  <span style="font-weight: bold" class="text-danger">{{date('F j,Y')}}</span>

                            <br>
                            Time : <span style="font-weight: bold" class="text-danger">{{date('h:i a')}}</span>
                        </span>
                            <br><br><br>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Type : 
                                    <span  style="font-weight: bold;font-size:15px;" class="text-primary mb-2">Dentistry</span> <br><br>
        
                                 
                                    Appointment-Type : <span class="text-primary">Custom</span><br>
                                   Status : <span class="text-danger">Pending</span>
                                </li>
                                <li class="list-group-item">
                                    Doctor : 
                                    <span  style="font-weight: bold;font-size:15px;" class="text-primary mb-2">Dr. Ong</span> <br><br>
        
                                    Details :
                                    <br>
                                    Contact # : <span class="text-primary">09557653775</span><br>
                                    Email : <span class="text-primary">Ong@gmail.com</span>
                                </li>
                              
                              </ul>

                           
                          

                            <br><br>
                            <h6 style="font-size:12px;text-align:center"></h6>
                            Type : 
                            <span  style="" class="text-primary">Custom Appointment</span>
                            <br>
                            Status : <span class="text-danger af">Pending</span> 
                        </h6>
                    </div>
                    <div class="modal-footer bg-light" ></div>
                 
                </div>
                </div>
            </div>
                                </div>
                            </div>

                        </td> --}}
                        <td>{{date('F j,Y',strtotime($row->created_at))}}</td>
                       
                      </tr>
                      
                      @endforeach
                    </tbody>
                  </table>    
               </div>
            </div>
            </div>
          </div>

        </div>
   
   </div>


@endsection