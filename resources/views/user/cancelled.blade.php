<div class="container p-3">
  @if(count($cancelleddis)>=1)
  @foreach ($cancelleddis as $row)

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

                 <hr>
                 Remarks :  <span class="text-danger">
                    {{$row->remarks}}
                  </span>
                 
       
                   @endforeach
               </h6>
          
               </h6>
              
       
       
                 </div>
             </div>
           
           </div>

    @endforeach
    @else 
    <h5 style="font-size:14px;text-align:center">
    No appointment yet..
    </h5>
    @endif
</div>