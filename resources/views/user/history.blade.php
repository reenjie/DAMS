  @php
          $history = DB::select('SELECT * FROM `records` where userID = '.Auth::user()->id.' ');
         
          @endphp
          @if(count($history)>=1)
 <button  class="btn btn-sm btn-light text-primary" onclick="window.location.href='{{route('admin.downloadalldata',['id'=>Auth::user()->id,'apptID'=>$history[0]->appointment])}}' "><i class="fas fa-download"></i> Download Patient Details</button>
            @endif
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link btn btn-success  active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-panes" type="button" role="tab" aria-controls="home-tab-pane" style="font-size:14px" aria-selected="true">Medical Treatment</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link btn btn-success" style="font-size:14px" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-panes" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Appointment Details</button>
  </li>

</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home-tab-panes" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
    <div class="container table-responsive">
      <table class="table table-striped table-sm " style="font-size:14px">
        <thead>
          <tr class=" text-secondary">
            <th>Date-Completed</th>
            <th>Diagnostics</th>
            <th>Treatment</th>
            <th>Remarks</th>
            <th>Purpose</th>
            <th>Doctor</th>

          </tr>

        </thead>
        <tbody>
         
          @foreach ($history as $apt )

          @php
          $appt = DB::select('SELECT * FROM `appointments` where id = '.$apt->appointment.' ');
          @endphp
            

          <tr style="font-size: 14px">
            <td>{{date("@h:ma F j,Y",strtotime($apt->created_at))}}</td>
            <td>{{$apt->diagnostics}}</td>
            <td>{{$apt->treatment}}</td>
            <td>{{$apt->remarks}}</td>
            <td>
              {{$appt[0]->purpose}}
            </td>
            <td>Dr. {{$appt[0]->doctor}}
              @foreach ($alldoctor as $dc )
              @if($dc->id == $appt[0]->doctor)
              {{$dc->name}}
              <br>
              <span style="font-size: 11px"> {{$dc->email ." | ".$dc->contact}}</span>
              @endif
              @endforeach
            </td>

          </tr>



          @endforeach
        </tbody>
      </table>


    </div>




  </div>
  <div class="tab-pane fade" id="profile-tab-panes" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

    <div class="container">
      <table class="table table-striped table-sm table-bordered" style="font-size:14px">
        <thead>
          <tr class=" text-secondary">
            <th>Date of Appointment</th>
            <th>Time Frame</th>



            <th>Doctor</th>

          </tr>

        </thead>
        <tbody>
          @foreach ($completeappt as $apt )
          @php
          $sched = DB::select('select * from schedules where id = '.$apt->apptID.' ');
          @endphp
          @if($apt->user_id == Auth::user()->id)

          @foreach ($sched as $ss)
          <tr style="font-size: 14px">
            <td>{{date('F j,Y',strtotime($ss->dateofappt))}}</td>
            <td>{{date('h:i a',strtotime($ss->timestart)).' - '.date('h:i a',strtotime($ss->timeend))}}</td>
            <td>Dr. {{$apt->doctor}}
              @foreach ($alldoctor as $dc )
              @if($dc->id == $apt->doctor)
              {{$dc->name}}
              <br>
              <span style="font-size: 11px"> {{$dc->email ." | ".$dc->contact}}</span>
              @endif
              @endforeach
            </td>

          </tr>
          @endforeach


          @endif


          @endforeach
        </tbody>
      </table>


    </div>


  </div>

</div>
