@extends('layouts.admin_layout')

@section('content')
   <div class="container">
    <div class="titlebar">
        <h4 class="hf mb-3">Schedules</h4>
        
    </div>
   
        <div class="container">
            
          <div class="card">
            <div class="card-body">
            <div class="container">

                @if(Session::get('Success'))
                <div class="row">
                
                     <div class="alert alert-success alert-dismissible fade af show" role="alert">
                        {{Session::get('Success')}}
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>
                 
                </div>
                
             @endif

             @if(Session::get('Error'))
             <div class="row">
             
                  <div class="alert alert-danger alert-dismissible fade af show" role="alert">
                     {{Session::get('Error')}}
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
              
             </div>
             
          @endif


              <!-- Button trigger modal -->
<button type="button" class="btn btn-secondary btn-sm mb-2 px-4" data-bs-toggle="modal" data-bs-target="#exampleModal">
   add
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title " id="exampleModalLabel">Add Schedule</h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('add.saveschedule')}}" method="post">
            @csrf
      
        <div class="modal-body">
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

            <div class="col-md-12 mt-2 mb-2">
                <label for="">No of Patient to accomodate</label>
                <input type="number" value="5" class="form-control" min="1" name="noofpatient" required> 
            </div>
            <div class="col-md-12 mt-2">
                <label for="">Remarks</label>
                <textarea name="remarks" class="form-control" id="" cols="20" rows="10"></textarea>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success btn-sm">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
                <div class="table-responsive">
                    <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
                        <thead>
                          <tr class="table-success">
                            <th scope="col">Date</th>
                            <th scope="col">Time Start</th>
                            <th scope="col">Time End</th>
                            <th scope="col">Number of Patients</th>
                          {{--   <th scope="col">Status</th> --}}
                            <th scope="col">Date-added</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            @php
                                   
                            $used = DB::select('select * from appointments where apptID='.$row->id.'  ');
                      
                        @endphp
                            <tr>
                                <td>{{date('F j,Y',strtotime($row->dateofappt))}}</td>
                                <td>{{date('H:ia',strtotime($row->timestart))}}</td>
                                <td>{{date('H:ia',strtotime($row->timeend))}}</td>
                                <td>{{$row->noofpatients}}</td>
                                <td>{{date('H:ia F j,Y',strtotime($row->created_at))}}</td>  
                                 <td>
                                @if(date('Y-m-d') > $row->dateofappt)
                                <span class="badge bg-danger">Inactive/Expired</span>
                                @else 
                            

                                    @if(count($used)>=1)
                                    <span class="badge bg-success">Active/USED</span>
                                    @else 
                                    <span class="badge bg-success">Active/UNUSED</span>
                                    @endif
                      
                                @endif

                                </td>

                                <td>
                                    <div class="btn-group">

                     
                                        <button data-id = "{{$row->id}}"
                                            @if(count($used)>=1)
                                                disabled
                                             
                                            @endif
                                         
                                          
                                            class="btn
                                            @if(count($used)>=1)
                                            text-secondary

                                            @else 

                                            text-danger
                                            @endif
                                            btn-light btndelete  btn-sm"><i class="fas fa-times"></i></button>
                                    </div>
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
    $('.btndelete').click(function(){
  var id =$(this).data('id');
  
 
  swal({
title: "Are you sure?",
text: "Once deleted, you will not be able to recover this!",
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
$(this).html('Deleting ..');
window.location.href='{{route("delete.deletesched")}}'+'?id='+id;
} else {

}
});
})

</script>

@endsection