@extends('layouts.admin_layout')

@section('content')
<div class="container">
  <div class="titlebar">
    <h4 class="hf mb-3">Referral Station</h4>

  </div>

  <div class="container">
    <div class="row">
      <div class="col-md-7">
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
        <ul class="list-group list-group-flush">
          @if(count($data)>=1)
          @foreach ($data as $appt)
          <div class="card mb-4 border-danger shadow">
            <div class="card-body">
              @foreach ($user as $item)


              @if($item->id == $appt->doctor)
              <h6 style="font-size: 14px">Referred By:</h6>
              <h6 class="text-primary" style="font-weight:bold">Dr. {{$item->name}}</h6>
              <hr>
              @endif
              @if($item->id == $appt->user_id )
              <div>
                <h6 style="font-size: 14px">Patient Details:</h6>
                <button style="float:right" class="btn btn-sm btn-light text-primary" onclick="window.location.href='{{route('admin.downloadWithData',['id'=>$item->id,'apptID'=>$appt->id])}}' "><i class="fas fa-download"></i> Download Patient Details</button>
                <h6> {{$item->name}} ( <span style="font-size:13px">{{$item->email}} </span> )
                  <br>
                  <i class="fas fa-phone"></i> {{$item->contactno}}
                  <br>
                  <h6 class="mt-3" style="font-size: 12px">REMARKS:</h6>
                  <span class="text-danger">{{$appt->remarks}}</span>
                  <br>
                </h6>
              </div>
              @endif

              {{-- @if($appt->attachedfile == null)
                      <span style="font-size:12px">No attached File.</span>
                       @else
                       <div class="p-2">
                        <span style="font-size: 12px;color:rgb(59, 58, 58)">Attached Medical Certificate </span>
                        <br>
                      <a href="{{asset('attachments/').'/'.$appt->attachedfile}}" target="_blank">
              <i class="fas fa-image"></i> {{$appt->attachedfile}}
              </a>

            </div>
            @endif --}}



            @endforeach








            <div class="" style="float: right">
              <button data-id="{{$appt->id}}" data-ref="{{$appt->refferedto_doctor}}" data-patient="{{$appt->user_id}}" class="btnaccept btn btn-link text-primary btn-sm">Accept</button>


              <button data-id="{{$appt->id}}" class="btncancel btn btn-link text-danger btn-sm">Decline</button>
            </div>
          </div>
      </div>

      @endforeach
      @else
      <div style="text-align: center">
        <img src="https://cdn.iconscout.com/icon/free/png-256/data-not-found-1965034-1662569.png" alt="">
        <h5>No referral found.</h5>
      </div>
      @endif

      </ul>

    </div>
    <div class="col-md-5">

      @if(count($appr_appointments)>=1)
      @foreach ($appr_appointments as $row)
      @foreach ($user as $patient)
      @if($patient->id == $row->user_id)

      <div class="card  mb-2 border-success">
        <div class="card-body">

          <button style="float:right;text-decoration:none;font-size:13px" class="btn btn-link btn-sm" data-bs-toggle="modal" data-bs-target="#medhistory">Referral History</button>


          <div class="modal fade" id="medhistory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-body">
                  <button type="button" style="float:right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  <div class="badge mb-4 bg-success" style="font-size: 15px" id="exampleModalLabel">Referral History</div>
                  <div class="container">
                    <table class="table table-striped table-sm ">
                      <thead>
                        <tr class="table-success text-secondary">
                          <th>Date-Referred</th>
                          <th>From</th>
                          <th>To</th>


                          <th>Remarks</th>

                        </tr>

                      </thead>
                      <tbody>
                        @foreach ($refhistory as $hist )

                        @if($hist->user_id == $row->user_id)
                        <tr style="font-size: 14px">
                          <td>{{date("h:ia F j,Y",strtotime($hist->created_at))}}</td>
                          <td style="font-style: italic" class="text-secondary">

                            Referred : <br>
                            <span class="text-dark" style="font-style: normal">
                              Dr.
                              @foreach ($doctor as $item1)
                              @if($item1->id == $hist->fromdoctor)
                              {{$item1->name}}
                              @endif
                              @endforeach</span>
                          </td>
                          <td style="font-style: italic" class="text-secondary">

                            Referred : <br>
                            <span class="text-dark" style="font-style: normal">
                              Dr.
                              @foreach ($doctor as $item1)
                              @if($item1->id == $hist->todoctor)
                              {{$item1->name}}
                              @endif
                              @endforeach</span>
                          </td>
                          <td> {{$hist->remarks}}

                          </td>

                        </tr>

                        @endif


                        @endforeach
                      </tbody>
                    </table>


                  </div>

                </div>

              </div>
            </div>
          </div>

          <h6 class="af" style="font-weight:bold">{{$patient->name}}</h6> ( <span style="font-size:13px">{{$patient->email}} </span> )
          <br>
          <i class="fas fa-phone"></i> {{$patient->contactno}}
          <br>
          <button onclick="window.location.href='{{route('admin.appointment')}}' " class="btn btn-light text-primary btn-sm">View Booking</button>
          <button data-id="{{$row->id}}" data-pid="{{$patient->id}}" class="btn btn-light text-danger btn-sm btnrefer" style="font-weight: bold;float:right">REFER</button>

        </div>
      </div>


      @endif
      @endforeach



      @endforeach
      @else

      <h6 style="text-align: center;" class="af">
        No Appointment Found.
      </h6>
      @endif

    </div>
  </div>


</div>

</div>

<script>
  $('.btnaccept').click(function() {
    var id = $(this).data('id');
    var ref = $(this).data('ref');
    var patient = $(this).data('patient');

    swal({
        title: "Are you sure?",
        text: "You will have to set the appointment. Proceed?",
        icon: "warning",
        buttons: true,
        dangerMode: false,
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location.href = '{{route("admin.accept_referral")}}' + '?id=' + id + '&ref=' + ref + '&patient=' + patient;
        } else {

        }
      });

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



  $('.btncancel').click(function() {
    var id = $(this).data('id');

    swal("Please Write a Remarks or Reason of Declining Referral:", {
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
          $(this).removeClass('btn-primary').addClass('btn-light').html('<span class="text-danger" style="font-size:12px">Declining..</span>');
          window.location.href = '{{route("home.disapprove_booking")}}' + '?id=' + id + '&remarks=' + value;
        }
      });

    /*    swal({
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
@endsection