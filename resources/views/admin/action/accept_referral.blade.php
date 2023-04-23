@extends('layouts.admin_layout')
@section('content')
<div class="container">
  <div class="titlebar">
    <h4 class="hf mb-3">Accepting Referral</h4>
  </div>
  <a href="{{route('admin.referral')}}" class="btn btn-light btn-sm mb-2">Back</a>
  @foreach ($data as $row)

  @endforeach
  <div class="row">

    <div class="col-md-6">
      @foreach ($user as $patient)


      <div class="card shadow ">
        <div class="card-body">

          <h6 class="af" style="font-weight:bold">{{$patient->name}}</h6> ( <span style="font-size:13px">{{$patient->email}} </span> )
          <br>
          <i class="fas fa-phone"></i> {{$patient->contactno}}
          <br>

          <div class="card mt-2">
            <div class="card-body">
              <h6>Let the patient Rebook or Reschedule based on your available schedules ..</h6>
              <br>
              <form action="{{route('edit.saveoutbook')}}" method="post">
                @csrf
                <input type="hidden" value="{{$id}}" name="id">
                <input type="hidden" value="{{$doctor}}" name="doctor">
                <input type="hidden" value="{{$patId}}" name="patient">
                <input type="hidden" value="{{$specialization}}" name="categoryid">
                <input type="checkbox" id="userbook" style="width:18px;height:18px" name="userrebook"> <span class="text-danger">Check here and click Save.</span>
                <button type="submit" class="btn btn-primary">Save</button>
              </form>

            </div>
          </div>
        </div>
      </div>




      @endforeach


    </div>
    <div class="col-md-6">


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
                    <form method="post" action="{{route('edit.rebook')}}" id="booknow">
                      @csrf
                      <input type="hidden" value="{{$item->id}}" name="scheduleid">
                      <input type="hidden" value="{{$id}}" name="id">
                      <input type="hidden" value="{{$doctor}}" name="doctor">
                      <input type="hidden" value="{{$patId}}" name="patient">
                      <input type="hidden" value="{{$specialization}}" name="categoryid">
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

    </div>


  </div>
</div>

<script>
  $('#userbook').click(function() {
    if ($(this).prop('checked') == true) {

      $('#da').removeAttr('required').val('').attr('readonly', true);
      $('#ta').removeAttr('required').val('').attr('readonly', true);;


    } else {
      $('#da').attr('required', true).removeAttr('readonly');
      $('#ta').attr('required', true).removeAttr('readonly');

    }
  })
</script>
@endsection