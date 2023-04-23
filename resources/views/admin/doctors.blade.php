@extends('layouts.admin_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Doctors</h4>
            

        </div>

        <div class="card shadow-sm">
            <div class="card-body">
           <div class="container">
            {{-- <button class="btn btn-dark btn-sm px-3 mb-2" onclick="window.location.href='{{route('admin.adddoctor')}}' ">Add</button> --}}

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
            <div class="table-responsive">
                <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
                    <thead>
                      <tr class="table-primary">
                        <th scope="col">Name</th>
                        <th scope="col">Specialties</th>
                        <th scope="col">Email & Contact No</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date-added</th>
                        {{-- <th scope="col">Action</th> --}}
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                            <td style="font-weight: bold">Dr. {{$row->firstname.' '.$row->lastname}}</td>
                            <td>
                                
                                @foreach ($category as $item)
                                @if($item->id == $row->category)
                                    {{$item->name}}
                                @endif
                                @endforeach
                            </td>
                            <td>
                               {{$row->email}}
                                <br>
                                #{{$row->contact}}
                            </td>
                            <td>
                              <select name="" id="" data-id="{{$row->id}}" class="changestatus af form-select" style="font-size:14px">
                                @if($row->isavailable == 0)
                                <option value="0">Available</option>
                                @else 
                                <option value="1">Unavailable</option>
                                @endif
                                <option value="0">Available</option>
                                <option value="1">Unavailable</option>
                              </select>
                            </td>
                          
                            <td>{{Date('h:ia F j,Y',strtotime($row->created_at))}}</td>
                          
                            {{-- <td>
                                <div class="btn-group">
                                 
                                    <button class="btn btn-light btn-sm text-success" onclick="window.location.href='{{route('admin.edit_doctor',$row->id)}}' "><i class="fas fa-edit"></i></button>
                                    <button data-id="{{$row->id}}" class="btndelete btn btn-light btn-sm text-danger"><i class="fas fa-trash-can"></i></button>
                                </div>
                            </td> --}}
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
text: "Once deleted, you will not be able to recover this!",
icon: "warning",
buttons: true,
dangerMode: true,
})
.then((willDelete) => {
if (willDelete) {
  $(this).html('Deleting ..');
  window.location.href='{{route("delete.delete_doctor")}}'+'?id='+id;
} else {

}
});
  })

  $('.changestatus').change(function(){
    var id = $(this).data('id');
    var stat = $(this).val();

    $.ajax({
      url:'{{route("edit.update_doctor_stat")}}',
      method : 'get',
      data :{id:id,stat:stat},
      success:function (data){

      }
    })

  })
    
  </script>

@endsection