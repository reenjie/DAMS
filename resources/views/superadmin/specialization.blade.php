@extends('layouts.superadmin_layout')
@section('content')
    <div class="container">
        <div class="titlebar">
            <h4 class="hf mb-3">Specialization</h4>
            <div class="card shadow-sm">
                <div class="card-body">

                <button data-bs-toggle="modal" data-bs-target="#add" class="btn btn-secondary btn-sm px-3 mb-2">Add</button>

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
                            <th scope="col">Date-Created</th>
                            <th scope="col">Status</th>
                        
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @if(count($data) >= 1)
                            @foreach ($data as $row)
                            <tr>
                                <td style="font-weight: bold" class="text-primary">{{$row->name}}</td>
                                <td>{{Date('F j,Y',strtotime($row->created_at))}}</td>
                                <td>
                                    @php
                                    $count = 0;
                                @endphp
                                @foreach ($doc as $item)
                                @php
                                    $spec = unserialize($item->specialization);
                                @endphp
                                @for ($i = 0; $i < count($spec); $i++)
                                @if($spec[$i] == $row->id)
                                    
                                @php
                                    $count++;
                                @endphp
                                  @endif
                                @endfor
                                   
                                @endforeach
                                  @if($count>=1)
                                  <span class="badge text-bg-success">Used</span>
                                  @else 
                                  <span class="badge text-bg-danger">Unused</span>
                                  @endif

                                 
                                </td>
                              
                             
                                <td>
                                    <div class="btn-group">
                                        <button data-bs-toggle="modal" data-bs-target="#edit{{$row->id}}" class="btn btn-light btn-sm text-success"><i class="fas fa-edit"></i></button>
 <button class="btn btn-light btn-sm text-danger btndelete" data-id="{{$row->id}}"><i class="fas fa-trash-can"></i></button>
                                    </div>
                                </td>
                              </tr>
                                

 <div class="modal fade" id="edit{{$row->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<form action="{{route('edit.edit_category')}}" method="post">
@csrf
<div class="modal-body">
<button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<br><br>
<h6 class="af">
Update Specialization
</h6>
<input type="text" value="{{$row->name}}" name="category" class="form-control" required>
<input type="hidden" name="id" value="{{$row->id}}">

</div>
<div class="modal-footer">

<button type="submit" class="af btn btn-info btn-sm px-3 py-2">Update</button>
</div>
</form>
</div>
</div>
</div> 
                            @endforeach
                        @else


                          @endif
                         
                        </tbody>
                      </table>
                </div>

                </div>
            </div>

        </div>
            

    </div>

  

<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
<div class="modal-content">
<form action="{{route('add.add_category')}}" method="post">
@csrf
<div class="modal-body">
<button type="button" style="float: right" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<br><br>
<h6 class="af">
Add Specialization
</h6>
<input type="text" name="category" class="form-control" required>
@isset($clinic_id)
<input type="hidden" name="clinic" value="{{$clinic_id}}">
@endisset
</div>
<div class="modal-footer">

<button type="submit" class="af btn btn-success btn-sm px-3 py-2">Save</button>
</div>
</form>
</div>
</div>
</div>
 
    <script>
     
        $('#select_clinic').change(function(){
            var val = $(this).val();  
        window.location.href='{{route("superadmin.sort_clinics","")}}'+'/'+val;
        }) 

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
    window.location.href='{{route("delete.delete_Category")}}'+'?id='+id;
  } else {
  
  }
});
    })
      
    </script>
@endsection