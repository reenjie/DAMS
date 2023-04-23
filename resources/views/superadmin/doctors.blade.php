@extends('layouts.superadmin_layout')
@section('content')
<div class="container">
  <div class="titlebar">
    <h4 class="hf mb-3">Doctors</h4>


  </div>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <button class=" btn btn-secondary btn-sm px-3 mb-2" onclick="window.location.href='{{route('superadmin.add_doctor')}}' ">Add</button>
          </div>
          <div class="col-md-6">
            <select name="" class="form-select" id="spec">
              <option value="">Sort By Specialization</option>
           
              @php
                  $spez = DB::select('SELECT * FROM `categories`');
              @endphp

              @foreach ($spez as $item)
           
              <option value="{{$item->id}}">{{$item->name}}</option>     
      
              @endforeach
              <option value="all">All</option>
            </select>
          </div>
          <div class="col-md-3">

          </div>
        </div>

        

        @if(Session::get('Success'))
        <div class="row">

          <div class="alert alert-success alert-dismissible fade af show" role="alert">
            {{Session::get('Success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

        </div>

        @endif
        <br><br>
        @foreach ($spez as $item)
              @if(request('id') == $item->id)
           
        Categorized By :     <h6 style="text-align: center"  class="p-2 text-center badge bg-primary">{{$item->name}}</h6>
              @endif
        @endforeach
        <div class="table-responsive">
          <table class="table table-striped table-sm af" style="font-size: 14px" id="myTable">
            <thead>
              <tr class="table-success">
                <th scope="col">Name</th>
                <th scope="col">License</th>
                <th scope="col">Email & Contact No</th>
                <th scope="col">Specialization</th>
                <th scope="col">Appt-Schedules</th>
                <th scope="col">Date-added</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($data as $row)
             @if(request('id')) 
             @php
             $specs = unserialize($row->specialization);   
             @endphp     
             <ul class="list-group list-group-flush">
               @for ($i = 0; $i < count($specs); $i++) 
               @if(request('id') == $specs[$i])
               @include('superadmin.doctor_data')
                @endif
               @endfor
             </ul>
              @else 
              @include('superadmin.doctor_data')
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#spec').change(function(){
    var val = $(this).val();
    if(val == 'all'){
      window.location.href='{{route("superadmin.doctors")}}';
      return;
    }
    window.location.href='?id='+val;
  })
  $('.btndelete').click(function() {
    var id = $(this).data('id');


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
          window.location.href = '{{route("delete.delete_doctor")}}' + '?id=' + id;
        } else {

        }
      });
  })
</script>

@endsection