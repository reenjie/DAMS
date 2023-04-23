@extends('layouts.user_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Cancel Booking</h4>         
        </div>

        <div class="row">
            <div class="col-md-8">
                @if(count($data)>=1)
                @foreach ($data as $row)
                               <div class="card shadow mb-2 searchfilter">
                                   <div class="card-header">
                                      <h6  style="font-size:12px"><span>Transaction# {{$row->id}}</span></h6> 
                                     
                                   </div>
                                   <div class="card-body">
               
                                       <div class="row">
                                  
                                           <div class="col-md-12">
                                               <h6 class="af" style="text-align: center">
                                                 
                                                  <span style="font-size:14px"> Appointment Date </span> : <span class="text-danger">{{date('F j,Y',strtotime($row->dateofappointment))}}</span>
                                                  <br>
                                                  <span style="font-size:14px"> Time </span> : <span class="text-danger">{{date('h:i a',strtotime($row->timeofappointment))}}</span>
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
                                               </h6>
                                             
                                       
                                           </div>
                                       </div>
                                      
                                   </div>
                                   <div class="card-footer">
                                    <h6 style="font-size:13px">Status: <span class="badge text-bg-primary" style="padding: 5px;font-size:12px">Pending</span></h6>
                                    <div class="row">
                                      
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                <textarea name="" class="form-control reason" style="resize: none" id="{{$row->id}}reason" cols="30" rows="10" placeholder="Please let us know why you are cancelling your booking.."></textarea>
                                                <div class="invalid-feedback">
                                                    <span style="font-size:12px">Please Provide a Reason</span>
                                                </div>
                                                <button data-id="{{$row->id}}" class="btn btncancel btn-light text-danger mt-2 btn-sm" style="font-weight:bold">CANCEL <i class="fas fa-ban"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                   
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
        $('.reason').keyup(function(){
            $(this).removeClass('is-invalid');
        })
        $('.btncancel').click(function()
        {
            var id = $(this).data('id');
            var val = $('#'+id+'reason').val();

            if(val == ''){
                $('#'+id+'reason').addClass('is-invalid');
            }else {
                window.location.href='{{route("edit.cancel_appointment")}}'+'?id='+id+'&remarks='+val;
            }

        })
    </script>

@endsection