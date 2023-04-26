@extends('layouts.superadmin_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Patients</h4>
            

        </div>

        <div class="card shadow-sm">
            <div class="card-body">
           <div class="container">
            {{-- <button class="btn btn-secondary btn-sm px-3 mb-2" onclick="window.location.href='{{route('superadmin.add_patient')}}'" >Add</button> --}}
            @if(Session::get('Success'))
            <div class="row">
             <div class="col-md-8"></div>
             <div class="col-md-6">
                 <div class="alert alert-success alert-dismissible fade af show" role="alert">
                    {{Session::get('Success')}}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
             </div>
            </div>
            
         @endif
            <div class="table-responsive">
                <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
                    <thead>
                      <tr class="table-primary">
                        <th scope="col">Name</th>
                        <th scope="col">Email & Contact No</th>
                        <th scope="col">No of Appointment</th>
                        <th scope="col">Date-registered</th>
                        {{-- <th scope="col">Action</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td style="font-weight: bold">{{$row->name}}</td>
                            <td>
                               {{$row->email}}
                                <br>
                                #{{$row->contactno}}
                            </td>
                            <td style="font-weight: bold" class="text-primary">
                                @php
                                    $count = 0;
                                @endphp
                                @foreach ($appt as $item)
                                    @if($row->id == $item->user_id)
                                       @php
                                           $count++
                                       @endphp
                                    @endif
                                @endforeach

                              @if($count>=1)
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
                                            @php
                                        $schedule = DB::select('SELECT * FROM `schedules` where id = '.$ap->apptID.' ');
                                     
                                      @endphp
                                      @if($ap->apptID == 0)
                                        <span style="color:red">To set Schedule.</span>
                                        @else 
                                          <h6 style="font-size:13px" class="af mb-3 bg-light shadow p-3">
                                        <span style="float: right">   Date :  <span style="font-weight: bold" class="text-danger">{{date('F j,Y',strtotime($schedule[0]->dateofappt))}}</span>
               
                                           <br>
                                           Time : <span style="font-weight: bold" class="text-danger">{{date('h:i a',strtotime($schedule[0]->timestart)).' - '.date('h:i a',strtotime($schedule[0]->timeend))}}</span>
                                       </span> 
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
                                                      <span class="text-danger">Cancelled</span>
    
                                                    
                                                      @endif
                                                      
                                                   </li>
                                                   
                                                   <li class="list-group-item">
                                                    @php
                                                        $docdata = DB::select('select * from users where id = '.$ap->doctor.' ');
                                                    @endphp
    
                                                    @foreach ($docdata as $doc)
                                                    Type : 
                                                    <span  style="font-weight: bold;font-size:15px;" class="text-primary mb-2">
                                                    @php
                                                     $specs = unserialize($doc->specialization);
                                                        $spez = DB::select('select * from categories ');
                                                    @endphp
                                                
                                                <ul class="list-group list-group-flush">

                                                    @for ($i = 0; $i < count($specs); $i++) @foreach($spez as $sp) @if($sp->id == $specs[$i])
                                                        <li class="list-group-item text-primary"> {{$sp->name}}</li>
                                                        @endif
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
                              @else
                             <span class="text-danger" style="font-size:11px">No booked appointments yet.</span> 
                              @endif

                            </td>
                           
                            <td>{{Date('h:ia F j,Y',strtotime($row->created_at))}}</td>
                            {{-- <td>
                                <div class="btn-group">
                                    <button onclick="window.location.href='{{route('superadmin.edit_patient',$row->id)}}' " class="btn btn-light btn-sm text-success"><i class="fas fa-edit"></i></button>
                                    <button data-id="{{$row->id}}" class="btndelete btn btn-light btn-sm text-danger"><i class="fas fa-trash-can"></i></button>
                                </div>
                            </td> --}}
                          </tr>
                            
                        @endforeach
                      
                     
                    </tbody>
                  </table>
            </div>
           </div>
            </div>
        </div>
    </div>
<script>
        $('.btndelete').click(function(){
     var id =$(this).data('id');
    
     swal({
title: "Are you sure?",
text: "Once deleted, You will not be recovered it.",
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
    $(this).html('Deleting');
 window.location.href='{{route("delete.delete_admin")}}'+'?id='+id;
} else {

}
});
 })
 </script>
@endsection
