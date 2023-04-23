@extends('layouts.admin_layout')

@section('content')



<div class="container">

  <div class="titlebar">
    <h4 class="hf mb-3">Appointments</h4>

    @if(Session::get('Success'))

    <div class="alert alert-success alert-dismissible fade af show" role="alert">
      {{Session::get('Success')}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>


    @endif

    <button class="btn btn-light text-primary mb-2 btn-sm" style="font-size:14px"  data-bs-toggle="modal" data-bs-target="#create">Create Appointment <i class="fas fa-edit"></i></button>

<!-- Modal -->
<div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Appointment</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.createmultipleappt')}}" method="post">
          @csrf
          <div class="row">
            <div class="col-md-12 mb-2"> 
              <label for="">Date of Appointment</label>
              <input type="date" class="form-control" name="doa" min="<?php echo date('Y-m-d', time() + 86400); ?>" required>
          </div>
    
          <div class="col-md-6">
              <label for="">Time Start</label>
              <input type="time" class="form-control" name="timestart" required> 
          </div>
          
          <div class="col-md-6">
              <label for="">Time End</label>
              <input type="time" class="form-control" name="timeend" required> 
          </div>
    
         
          <div class="col-md-12 mt-2">
              <label for="">Remarks</label>
              <textarea name="remarks" class="form-control" id="" cols="20" rows="10"></textarea>
          </div>
          </div>
  
          <h6 class="mt-3">Select Patient</h6>
          
          <table class="table table-striped table-sm">
            <thead>
              <tr>
                <th><input type="checkbox" required id="selectall"/></th>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email & Contact No</th>
            
              </tr>
            </thead>
            <tbody>
              @php
                  //$users = DB::select('select * from users where user_type = "patient" ');
                  $users = DB::select('select * from users ');
              @endphp
              @foreach ($users as $key => $item)
              <tr>
                <td><input type="checkbox"  value="{{$item->id}}" class="checkone" name="selected[]"></td>
                <td scope="row">{{$key+1}}</td>
                <td >
                  @if($item->proxyName)
                  Guardian : {{$item->proxyName}}
                  <br/>
                  @endif
                 <span style="font-weight: bold">{{$item->name}}</span> 
                
  
                </td>
                <td >
                  {{$item->email}}
                  <br>
                  {{$item->contactno}}
                </td>
              </tr> 
              @endforeach
            
            </tbody>
          </table>
          <button type="submit" class="btn btn-primary btn-sm">SELECT <i class="fas fa-check-circle"></i></button>
        </form>
      
       
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>

<script>
  $('#selectall').click(function(){
    if($(this).prop('checked') == true){
      $('.checkone').prop('checked',true);
    }else {
      $('.checkone').prop('checked',false);
    }
  })

  $('.checkone').click(function(){
    if($(this).prop('checked') == true){
      $('#selectall').prop('checked',true);
    }else {
      $('#selectall').prop('checked',false);
    }
  })

 
</script>
    <div class="dropdown">
      <button class="shadow btn btn-light btn-sm mb-2 text-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Advance Options <i class="fas fa-cogs"></i> <i class="fas fa-arrow-right"></i>
      </button>
      <ul class="dropdown-menu">

        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" id="pendingtab" style="font-size: 13px">Pending</a></li>
        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModal" id="approvedtab" style="font-size: 13px">Approved</a></li>
        <li><a class="dropdown-item" id="cancelledtab" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-size: 13px">Cancelled</a></li>
        <li><a class="dropdown-item" id="disapprovedtab" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-size: 13px">Disapproved</a></li>
        <li><a class="dropdown-item" id="completedtab" data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-size: 13px">Completed</a></li>
      </ul>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title fs-5" id="exampleModalLabel"></h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="viewappts">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>

          </div>
        </div>
      </div>
    </div>

  </div>


  <div class="row">
    @if(count($data)>=1)
    @foreach ($data as $row)

    <div class="col-md-12">
      <div class="card shadow mb-2">
        <div class="card-body text-secondary" style="font-size:14px">
          @php
          $schedule = DB::select('select * from schedules where id ='.$row->apptID.' ');

          // $doctor = DB::select('select * from users where id = '.$row->doctor.' ');
          $userinfo = DB::select('select * from users where id = '.$row->user_id.' ')
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
          <button style="" class="btn btn-sm btn-link text-primary" onclick="window.location.href='{{route('admin.downloadalldata',['apptID'=>$row->id])}}' "><i class="fas fa-download"></i> Download Patient Details</button>

          @include('admin.history')
          <hr>
          <h6 style="text-align:center;font-size:13px">-- Patient Details --</h6>
          <h6 class="text-primary">
            @foreach ($userinfo as $user)

            @php
            $p_id = $user->id;

            @endphp
            {{$user->name}}
            <br>
            <span style="font-size:12px" class="text-secondary">{{$user->email}} </span>
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
          <br>
            @foreach ($schedule as $sched)
          Date of Appointment : <span class="text-danger">{{date('F j,Y',strtotime($sched->dateofappt))}}</span>
          <br>
          Time Frame :  <span class="text-danger">{{date('h:i a',strtotime($sched->timestart))}} - {{date('h:i a',strtotime($sched->timeend))}}</span>
          <br>
          @if($sched->remarks)
          Remarks : <span class="text-danger">
            {{$sched->remarks}}
          </span>
          @endif

        
          Purpose :  <span class="text-danger">
            {{$row->purpose}}
          </span>


            @endforeach
        </h6>
        <h6 style="text-align:center;font-size:13px">-- Actions --</h6>
        <h6 style="text-align: center"> 
          <div class="btn-group" >

            @if($row->status == 0)
            <button data-id="{{$row->id}}" class="btn btn-light btnapprove text-primary btn-sm">Approve <i class="fas fa-check-circle"></i></button>
            <button  data-id="{{$row->id}}" class="btn btncancel btn-light text-danger btn-sm">Disapprove <i class="fas fa-times-circle"></i></button>
            <button data-id="{{$row->id}}" data-pid="{{$p_id}}" style=" font-weight: bold" class="btnrefer  btn btn-light text-danger btn-sm af">REFER <i class="fas fa-arrow-right"></i></button>
            @endif

       


       </div>
        </h6>
          @if($row->status == 1)
            @include(' admin.approve_appointment') @elseif($row->status == 2)

                  @elseif($row->status == 3)

                  @elseif($row->status == 4)

                  @endif



        </div>
      </div>

    </div>

    @endforeach
    @else
    <h5 class="text-secondary" style="text-align: center;font-weight:bold">
      No Booked Appointments Yet..
    </h5>
    @endif




  </div>
  <script>
    $('.btnapprove').click(function() {
      var id = $(this).data('id');


      swal({
          title: "Are you sure to Approve this Booking? ",
          text: "",
          icon: "warning",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
            $(this).removeClass('btn-primary').addClass('btn-light').html('<span class="text-primary" style="font-size:12px">Approving..</span>');
            window.location.href = '{{route("home.approve_booking")}}' + '?id=' + id;
          } else {

          }
        });
    })

    $('.btncannot').click(function() {
      swal({
        title: "Doctor Unavailable!",
        text: "Disapproved Appointment or wait for the Doctors availability",
        dangerMode: true,
      });
    })
    $('.btncancel').click(function() {
      var id = $(this).data('id');

      swal("Please Write a Remarks:", {
          content: "input",
          icon: "warning",
          dangerMode: true,
        })
        .then((value) => {
          if (value == '') {
            swal({
              title: "Remarks Required!",
              text: "Please provide a Remarks to inform the patient.",
              icon: "error",
              button: "Close",
              dangerMode: true,
            });
          } else {
            $(this).removeClass('btn-primary').addClass('btn-light').html('<span class="text-danger" style="font-size:12px">Disapproving..</span>');
            window.location.href = '{{route("home.disapprove_booking")}}' + '?id=' + id + '&remarks=' + value;
          }
        });


    })

    function RequestPage(types) {
      var request = $.ajax({
        url: "{{route('home.viewbook')}}",
        method: "get",
        data: {
          types: types
        },
        dataType: "html"
      });

      request.done(function(msg) {
        $('#viewappts').html(msg);

      });

      request.fail(function(jqXHR, textStatus) {
        console.log(textStatus);
      });
    }
    $('#pendingtab').click(function() {
      RequestPage('pending');
    })

    $('#approvedtab').click(function() {
      RequestPage('approved');
    })

    $('#cancelledtab').click(function() {
      RequestPage('cancelled');
    })

    $('#disapprovedtab').click(function() {
      RequestPage('disapproved');
    })

    $('#completedtab').click(function() {
      RequestPage('completed');
    })


    $('.btnrefer').click(function() {
      var id = $(this).data('id');
      var pid = $(this).data('pid');
      var val = $('#' + id + 'remarks').val();
      if (val == '') {
        $('#' + id + 'remarks').addClass('is-invalid');
      } else {
        window.location.href = '{{route("admin.refer")}}' + '?id=' + id + '&remarks=' + val + '&patientId=' + pid;
      }
    })
  </script>
  @endsection