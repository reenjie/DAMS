@extends('layouts.superadmin_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Clinics</h4>
            

        </div>

        <div class="card shadow-sm">
            <div class="card-body">
           <div class="container">
            <button class="btn btn-dark btn-sm px-3 mb-2" onclick="window.location.href='{{route('superadmin.add_clinic')}}' ">Add</button>
            <div class="table-responsive">
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
                <table class="table table-striped table-sm table-bordered af" style="font-size: 14px" id="myTable">
                    <thead>
                      <tr class="table-primary">
                        <th scope="col">Name</th>
                        <th scope="col">Location</th>
                        <th scope="col">Date-Created</th>
                        <th scope="col">No. of Doctors</th>
                        <th scope="col">Categories</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td style="font-weight: bold">{{$row->name}}</td>
                            <td>{{$row->street.' '.$row->barangay.' '.$row->city}}</td>
                            <td>{{Date('F j,Y',strtotime($row->created_at))}}</td>
                            <td>
                                <span class="text-primary">
                                  @php
                                        $count = 0;
                                       @endphp
                                  @foreach ($doctor as $item)
                                      @if($item->clinic == $row->id)
                                      @php
                                        $count++;
                                       @endphp
                                      @endif
                                  @endforeach
                                      {{$count}}
                                </span>
                            </td>
                            <td>
                                <ul class="list-group list-group-flush">
                                  @foreach ($category as $item)
                                  @if($row->id == $item->clinic)
                                  <li class="list-group-item text-info" style="font-weight: bold" >{{$item->name}}</li>
                                  @endif
                                  @endforeach
                                   
                                    
                                  </ul>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button onclick="window.location.href='{{route('superadmin.edit_clinic',$row->id)}}' " class="btn btn-light btn-sm text-success"><i class="fas fa-edit"></i></button>
                                    <button class="btndelete btn btn-light btn-sm text-danger" data-id="{{$row->id}}"><i class="fas fa-trash-can"></i></button>
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

    <script>
         $('.btndelete').click(function(){
        var id =$(this).data('id');
       
        swal({
  title: "Are you sure?",
  text: "All of the categories and Doctors data connected to this clinic will be deleted. Press ok to continue..",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    window.location.href='{{route("delete.delete_clinic")}}'+'?id='+id;
  } else {
  
  }
});
    })
    </script>
@endsection