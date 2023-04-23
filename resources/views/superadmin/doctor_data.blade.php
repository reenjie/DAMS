<tr>
    <td style="font-weight: bold">Dr. {{$row->name}}</td>
    <td>
      License#: {{$row->license}}
    </td>
    <td>
      {{$row->email}}
      <br>
      #{{$row->contactno}}
    </td>
    <td>
      @php
      $specs = unserialize($row->specialization);
      @endphp

      <ul class="list-group list-group-flush">

        @for ($i = 0; $i < count($specs); $i++) @foreach ($category as $ee) @if($ee->id == $specs[$i])

          <li class="list-group-item"> <span class="text-primary" style="font-weight: bold;text-transform:uppercase">{{$ee->name}}</span></li>
          @endif
          @endforeach

          @endfor
      </ul>




    </td>
    <td>
      @php
      $id = $row->id;
      $sched = DB::select('SELECT * FROM `schedules` where doctorid = '.$id.' ');
      @endphp
      <button class="btn btn-light text-primary border-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewappt{{$row->id}}">View all <span class="badge bg-danger">{{count($sched)}}</span></button>


      <!-- Modal -->
      <div class="modal fade" id="viewappt{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title " id="exampleModalLabel"><span style="font-weight:bold">Dr. {{$row->name}}</span> Schedules</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
                <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
                  <thead>
                    <tr class="table-success">
                      <th scope="col">Date</th>
                      <th scope="col">Time Start</th>
                      <th scope="col">Time End</th>
                      <th scope="col">Number of Patients</th>
                      {{-- <th scope="col">Status</th> --}}
                      <th scope="col">Date-added</th>
                      <th scope="col">Status</th>

                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sched as $e)
                    @php

                    $used = DB::select('select * from appointments where apptID='.$e->id.' ');

                    @endphp
                    <tr>
                      <td>{{date('F j,Y',strtotime($e->dateofappt))}}</td>
                      <td>{{date('H:ia',strtotime($e->timestart))}}</td>
                      <td>{{date('H:ia',strtotime($e->timeend))}}</td>
                      <td>{{$e->noofpatients}}</td>
                      <td>{{date('H:ia F j,Y',strtotime($e->created_at))}}</td>
                      <td>
                        @if(date('Y-m-d') > $e->dateofappt)
                        <span class="badge bg-danger">Inactive/Expired</span>
                        @else


                        @if(count($used)>=1)
                        <span class="badge bg-success">Active/USED</span>
                        @else
                        <span class="badge bg-success">Active/UNUSED</span>
                        @endif

                        @endif

                      </td>


                    </tr>
                   

                    @endforeach

             
                  </tbody>
                </table>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>

            </div>
          </div>
        </div>
      </div>
    </td>
    <td>{{Date('@h:ia F j,Y',strtotime($row->created_at))}}</td>

    <td>
      <div class="btn-group">
        <button onclick="window.location.href='{{route('superadmin.edit_doctor',$row->id)}}' " class="btn btn-light btn-sm text-success"><i class="fas fa-edit"></i></button>
        <button data-id="{{$row->id}}" class="btndelete btn btn-light btn-sm text-danger"><i class="fas fa-trash-can"></i></button>
      </div>
    </td>
  </tr>