@extends('layouts.superadmin_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Admin</h4>
            

        </div>

        <div class="card shadow-sm">
            <div class="card-body">
           <div class="container">
            <button class="btn btn-secondary btn-sm px-3 mb-2" onclick="window.location.href='{{route('superadmin.add_admin')}}' ">Add</button>

            @if(Session::get('Success'))
            <div class="row">
          
                 <div class="alert alert-success alert-dismissible fade af show" role="alert">
                    {{Session::get('Success')}}
                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
             
            </div>
            
         @endif
            <div class="table-responsive">
                <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
                    <thead>
                      <tr class="table-success">
                        <th scope="col">Name</th>
                        <th scope="col">Email & Contact No</th>
                      
                      {{--   <th scope="col">Status</th> --}}
                        <th scope="col">Date-added</th>
                        <th scope="col">Action</th>
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
                      
                            
                            {{-- <td>
                              
                                
                                <span class="badge text-bg-success">Online</span>
                        
                                <span class="badge text-bg-danger">Offline</span>
                             
                            </td> --}}
                            <td>{{Date('h:ia F j,Y',strtotime($row->created_at))}}</td>
                            <td>
                              @if($row->id != Auth::user()->id)
                                <div class="btn-group">
                                    <button class="btn btn-light btn-sm text-success" onclick="window.location.href='{{route('superadmin.edit_admin',$row->id)}}' "><i class="fas fa-edit"></i></button>
                                    <button data-id="{{$row->id}}" class="btndelete btn btn-light btn-sm text-danger"><i class="fas fa-trash-can"></i></button>
                                </div>
                              @endif
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
  text: "Once deleted, You will not be recovered it.",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    window.location.href='{{route("delete.delete_admin")}}'+'?id='+id;
  } else {
  
  }
});
    })
    </script>
@endsection